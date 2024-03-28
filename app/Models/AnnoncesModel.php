<?php

namespace Models;

class AnnoncesModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }

    public function getDataFromSell(): array
    {
        return self::where("status = 0");
    }
}