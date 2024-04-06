<?php

namespace Utils;

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



    //Rules supported
    // required, unique, ...


    public function validate(array $data, array $rules): array|bool
    {
        $validated = [];

        foreach ($rules as $key => $rule) {
            $fieldRules = explode(',', $rule);

            foreach ($fieldRules as $fieldRule) {
                $fieldRule = trim($fieldRule);

                if ($fieldRule === 'required' && empty($data[$key])) {
                    $validated[$key] = "Le champ $key est requis.";
                } elseif ($fieldRule === 'unique') {
                    $validated[$key] = "Le champ $key doit être unique.";
                }
            }
        }

        if (is_null($validated)) {
            return true;
        }
        return $validated;
    }
}