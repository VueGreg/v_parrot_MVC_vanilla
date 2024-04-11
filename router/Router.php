<?php

namespace Router;

use Utils\Request;
use Controllers\_404Controller;
use Middleware\Auth;

class Router
{

    private $request;
    private $routes;
    private $auth;
    private $access;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->routes = [];
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
                $this->request = new $requestInstance($this->request->getMethod(), $this->request->getUri(), $this->request->getParams(), $this->request->getPost());
            }

            [$className, $method] = $action;
            
            if ($this->auth->verify($path)) {
                if (class_exists($className) && method_exists($className, $method)) {
                    $class = new $className();
                    $params = ($this->request->getMethod() == 'POST' && $this->request->getPost() !== null) ? $this->request : $this->request->getParams();
                    return call_user_func_array([$class, $method], [$params ?? null]);
                }
            }

            $class = new _404Controller();
            return call_user_func_array([$class, 'index'], []);
        }
    }

    public function get(string $path, array $action): self
    {
        if ($this->request->getMethod() == 'GET') {
            $this->routes[$path] = ['action' => $action];
        }
        return $this;
    }

    public function dispatch()
    {
        return $this->setRoute($this->request);
    }

    public function post(string $path, array $action): self
    {
        if ($this->request->getMethod() == 'POST' && $this->request->getPost()) {

            $requestName = 'Request\Request' . explode('Controller', explode('\\', $action[0])[1])[0];
            $this->routes[$path] = ['action' => $action, 'request' => $requestName];
        }

        return $this;
    }

    public function put(string $route, array $controller, array $params = [])
    {

    }

    public function delete(string $route, array $controller, array $params = [])
    {

    }

    public function auth()
    {
        return $this->auth;
    }
}