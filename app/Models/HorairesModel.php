<?php

namespace Models;

class HorairesModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}