<?php

namespace Models;

class PermissionsModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}