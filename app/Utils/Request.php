<?php

namespace Utils;

class Request
{

    private $method;
    private $uri;
    private $params = [];
    private $post = [];
    private $className;
    private $authorization;

    public function __construct($method, $uri, $queryParams, $postData, $authorizationHeader)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->params = $queryParams;
        $this->post = $postData;
        $this->className = explode('\\', get_called_class());
        $this->authorization = $authorizationHeader;
    }

    public static function createFromGlobals()
    {
        $method = $_SERVER["REQUEST_METHOD"] ?? '';
        $uri = $_SERVER["REQUEST_URI"] ?? '';
        $queryParams = $_GET;
        $postData = json_decode(file_get_contents('php://input'), true) ?: [];
        $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        return new self($method, $uri, $queryParams, $postData, $authorizationHeader);
    }

    public function getMethod() 
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
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

    public function getClassName()
    {
        return $this->className;
    }

    public function getAuthorization()
    {
        return $this->authorization;
    }

    //Rules supported
    // required, unique, string, tel, email, text, ...


    public function validate(array $data, array $rules): array|bool
    {
        $validated = [];
        $errors = [];

        // var_dump($data);
        // die;

        $name = explode('Request', $this->className[1]);
        $className = 'Models\\' . $name[1] . 'sModel';
        $model = new $className();

        foreach ($rules as $key => $rule) {
            $fieldRules = explode(',', $rule);

            foreach ($fieldRules as $fieldRule) {
                $fieldRule = trim($fieldRule);

                if (($fieldRule === 'required' && empty($data[$key])) || $data[$key] === NULL) {
                    $validated[$key] = "Le champ $key est requis.";
                } elseif ($fieldRule === 'unique') {
                    $count = $model->query()->count()->where($key, '=', $data[$key])->get();

                    if ($count > 0) {
                        $validated[$key] = "Le champ $key est déjà utilisé.";
                    }

                } elseif ($fieldRule === 'string' && !preg_match("/^[a-zA-Z\s]*$/", $data[$key])) {
                    $validated[$key] = "Le champ $key doit contenir uniquement des lettres.";
                } elseif ($fieldRule === 'tel' && !preg_match("/^0[1-9]([ .-]?[0-9]{2}){4}$/", $data[$key])) {
                    $validated[$key] = "Le format du numéro de téléphone est incorect";
                } elseif ($fieldRule === 'email' && !preg_match("/^\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b$/", $data[$key])) {
                    $validated[$key] = "Le format de l'adresse mail est incorect";
                } elseif ($fieldRule === 'text' && !preg_match("/^[^\p{C}]*$/u", $data[$key])) {
                    $validated[$key] = "Le format $key contient des caractères non valides";
                }
            }
        }

        if (empty($validated)) {
            return true;
        }

        $errors['errors'] = $validated;
        return $errors;
    }
}