<?php

namespace Models;

class Vehicule_tableModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}