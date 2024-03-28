<?php

namespace Models;

class TemoignagesModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}