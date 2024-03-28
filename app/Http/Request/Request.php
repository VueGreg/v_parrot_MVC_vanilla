<?php

namespace Request;

class Request
{
    private $method;
    private $uri;
    private $params = [];
    private $post = [];

    public function __construct()
    {
        $this->method = $_SERVER["REQUEST_METHOD"] ?? '';
        $this->uri = $_SERVER["REQUEST_URI"] ?? '';
        $this->getQueryParams($_GET);
        $this->post = $_POST ?? [];
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

    public function getPost($field = null, $default = null)
    {
        if ($field === null) {
            return $this->post;
        } else {
            return $this->post[$field] ?? $default;
        }
    }
}