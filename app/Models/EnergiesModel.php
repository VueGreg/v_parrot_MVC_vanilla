<?php

namespace Models;

class EnergiesModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}