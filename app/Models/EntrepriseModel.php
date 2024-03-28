<?php

namespace Models;

class EntrepriseModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}