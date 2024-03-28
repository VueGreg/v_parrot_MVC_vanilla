<?php

namespace Models;

class List_equipementsModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}