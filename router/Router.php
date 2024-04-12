<?php

namespace Router;

use Utils\Request;
use Controllers\_404Controller;
use Middleware\Auth;
use Middleware\CrossSiteRequestForgery;

class Router
{

    private $request;
    private $routes = [];
    private $auth;
    private $csrf;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->auth = new Auth();
    }

    protected function setRoute(Request $request)
    {
        $this->request = $request;

        $path = explode('?', $this->request->getUri())[0];
        $routeData = $this->routes[$path] ?? null;

        if (is_array($routeData)) {
            $action = $routeData['action'] ?? null;
            $requestInstance = $routeData['request'] ?? null;

            if (isset($requestInstance) && class_exists($requestInstance)) {
                $this->request = new $requestInstance($this->request->getMethod(), $this->request->getUri(), $this->request->getParams(), $this->request->getPost(), $this->request->getAuthorization());
            }

            [$className, $method] = $action;
            
            if ($this->auth->verify($path)) {
                if (class_exists($className) && method_exists($className, $method)) {
                    $class = new $className();
                    $params = ($this->request->getMethod() != 'GET' && $this->request->getPost() !== null) ? $this->request : $this->request->getParams();
                    return call_user_func_array([$class, $method], [$params ?? null]);
                }
            }

            $class = new _404Controller();
            return call_user_func_array([$class, 'index'], []);
        }
    }


    public function get(string $path, array $action): self
    {
        if ($this->request->getMethod() == 'GET' || $this->request->getMethod() == 'DELETE') {
            return $this->addRoute($path, $action);
        }
        return $this;
    }

    public function post(string $path, array $action): self
    {
        $this->csrf = new CrossSiteRequestForgery();

        if ($this->auth->verify($path) && !$this->auth->getPageVitrine() && $this->request->getAuthorization() != '') {
            if ($this->request->getMethod() !== 'GET' && $this->request->getPost() && $this->csrf->validateCSRFToken($this->request->getAuthorization())) {
                $requestName = $this->getRequestName($action);
                return $this->addRoute($path, $action)->withRequest($path, $requestName);
            } else {
                throw new \Exception("Erreur de validation CSRF");
            }
        } elseif ($this->request->getMethod() !== 'GET' && $this->request->getPost()) {
            $requestName = $this->getRequestName($action);
            return $this->addRoute($path, $action)->withRequest($path, $requestName);
        }

        return $this;
    }

    public function put(string $path, array $action): self
    {
        if ($this->request->getMethod() === 'PUT') {
            return $this->post($path, $action);
        }

        return $this;
    }

    public function delete(string $path, array $action): self
    {
        $this->csrf = new CrossSiteRequestForgery();

        if ($this->auth->verify($path) && !$this->auth->getPageVitrine() && $this->request->getAuthorization() != '') {
            if ($this->request->getMethod() === 'DELETE' && $this->request->getParams() && $this->csrf->validateCSRFToken($this->request->getAuthorization())) {
                $requestName = $this->getRequestName($action);
                return $this->addRoute($path, $action)->withRequest($path, $requestName);
            }
        } elseif ($this->request->getMethod() === 'DELETE' && $this->request->getParams()) {
            $requestName = $this->getRequestName($action);
            return $this->addRoute($path, $action)->withRequest($path, $requestName);
        }

        return $this;
    }

    protected function addRoute(string $path, array $action): self
    {
        $this->routes[$path] = ['action' => $action];
        return $this;
    }

    protected function withRequest(string $path, string $requestName): self
    {
        $this->routes[$path]['request'] = $requestName;
        return $this;
    }

    protected function getRequestName(array $action): string
    {
        return 'Request\Request' . explode('Controller', explode('\\', $action[0])[1])[0];
    }

    public function dispatch()
    {
        return $this->setRoute($this->request);
    }

    public function auth()
    {
        return $this->auth;
    }
}