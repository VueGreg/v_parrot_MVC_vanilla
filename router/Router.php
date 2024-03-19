<?php

namespace Router;

use Request\Request;

class Router
{

    private $request;
    private $routes;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected function setRoute(string $uri)
    {
        $path = explode('?', $uri)[0];
        $action = $this->routes[$path] ?? null;

        if (is_array($action)) {
            [$className, $method] = $action;

            if (class_exists($className) && method_exists($className, $method)) {
                $class = new $className();
                return call_user_func_array([$class, $method], []);
            }
        }
    }

    public function get(string $path, array $action, array $params = [])
    {
        $this->routes[$path] = $action;
        $this->setRoute($this->request->getUri());
    }

    public function post(string $route, array $controller, array $datas = [])
    {
        
    }

    public function put(string $route, array $controller, array $params = [])
    {
        
    }

    public function delete(string $route, array $controller, array $params = [])
    {
        
    }
}