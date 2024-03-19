<?php

namespace Request;

class Request
{
    private $method;
    private $uri;
    private $params = [];

    public function __construct()
    {
        $this->method = $_SERVER["REQUEST_METHOD"] ?? '';
        $this->uri = $_SERVER["REQUEST_URI"] ?? '';
        $this->getQueryParams($_GET);
    }

    public function getMethod() 
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    private function getQueryParams($params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }
}