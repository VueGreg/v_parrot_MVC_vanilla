<?php

namespace Models;

class GalerieModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}