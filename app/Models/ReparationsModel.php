<?php

namespace Models;

class ReparationsModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }

    public function getCategories(): array
    {
        return self::distinct("categorie");
    }
}