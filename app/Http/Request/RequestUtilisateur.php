<?php

namespace Request;

use Utils\Request;

class RequestUtilisateur extends Request
{
    public function validation(array $data): array|bool
    {
        $rules = [
            'mail' => 'required, email',
            'mdp' => 'required'
        ];

        return $this->validate($data, $rules);
    }
}