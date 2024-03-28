<?php

namespace Models;

class MessagesModel extends Model
{
    public function getAllData(): array
    {
        return self::all();
    }
}