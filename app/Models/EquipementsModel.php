<?php

namespace Models;

class EquipementsModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}