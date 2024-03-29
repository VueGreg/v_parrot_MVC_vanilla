<?php

namespace Router;

use Controllers\_404Controller;
use Request\Request;

class Router
{

    private $request;
    private $routes;

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = [];
    }

    protected function setRoute()
    {
        $path = explode('?', $this->request->getUri())[0];
        $action = $this->routes[$path] ?? null;

        if (is_array($action)) {
            [$className, $method] = $action;

            if (class_exists($className) && method_exists($className, $method)) {
                $class = new $className();
                return call_user_func_array([$class, $method], [$this->request->getParams() ?? null]);
            }
        }

        $class = new _404Controller();
        return call_user_func_array([$class, 'index'], []);
    }

    public function get(string $path, array $action)
    {
        $this->routes[$path] = $action;
    }

    public function dispatch()
    {
        return $this->setRoute();
    }

    public function post(string $path, array $action)
    {
        if ($this->request->getMethod() == 'POST' && $this->request->getPost()) {
            $this->routes[$path] = $action;
            $this->setRoute($this->request->getUri(), $this->request->getPost());
        }
    }

    public function put(string $route, array $controller, array $params = [])
    {
        
    }

    public function delete(string $route, array $controller, array $params = [])
    {
        
    }
}