<?php

namespace Models;

use Request\RequestAnnonces;

class AnnoncesModel extends Model
{
    public function getAllAnnonces(): array
    {
       return $this->relationships()->has(['energies', 'vehicules'], true)->hasMany('images', 'galeries', false, 1);
    }

    public function store(array $data)
    {
        $request = new RequestAnnonces();
        if($request->validation($data)){
            $this->query()->create($data);
        }
    }
}