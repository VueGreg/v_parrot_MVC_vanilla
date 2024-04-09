<?php

namespace Request;

use Utils\Request;

class RequestMessage extends Request
{
    public function validation(array $data): array|bool
    {
        $rules = [
            'nom' => 'required, string',
            'prenom' => 'required, string',
            'num_telephone' => 'required, tel',
            'mail' => 'required, unique, email',
            'message' => 'required, text'
        ];

        return $this->validate($data, $rules);
    }
}