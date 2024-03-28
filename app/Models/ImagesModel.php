<?php

namespace Models;

class ImagesModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}