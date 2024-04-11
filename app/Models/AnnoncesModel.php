<?php

namespace Models;

use Request\RequestAnnonce;
use Utils\Model;

class AnnoncesModel extends Model
{
    public function getAllAnnonces(): array
    {
       return $this->relationships()->has(['energies', 'vehicules'], true)->hasMany('images', 'galeries', false, 1);
    }

    public function store(RequestAnnonce $request)
    {
        if($request->validation($request->getPost())){
            $this->query()->create($request->getPost());
        }
    }
}