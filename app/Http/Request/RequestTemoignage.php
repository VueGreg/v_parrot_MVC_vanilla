<?php

namespace Request;

use Utils\Request;

class RequestTemoignage extends Request
{
    public function validation(array $data): array|bool
    {
        $rules = [
            'nom' => 'required, string',
            'prenom' => 'required, string',
            'commentaire' => 'required, text',
            'note' => 'required',
            'etat' => 'required'
        ];

        return $this->validate($data, $rules);
    }
}