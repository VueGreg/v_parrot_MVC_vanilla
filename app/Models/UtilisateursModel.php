<?php

namespace Models;

class UtilisateursModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }

    public function getDataObject()
    {
        return self::objectData();
    }
}