<?php

namespace Models;

class ReparationsModel extends Model
{
    public function getAllData(): array
    {
        return $this->all();
    }
}