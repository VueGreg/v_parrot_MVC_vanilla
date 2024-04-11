<?php

namespace Request;

use Utils\Request;

class RequestAnnonce extends Request
{
    public function validation(array $data): array|bool
    {
        $rules = [
            'id_vehicules' => 'required, unique, int',
            'id_energies' => 'required, unique, int'
        ];

        return $this->validate($data, $rules);
    }
}