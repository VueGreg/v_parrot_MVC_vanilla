<?php

namespace Models;

use Utils\Model;

class EnergiesModel extends Model
{
    public function belongsToAnnonces()
    {
        return $this->relationships()->belongsTo('annonces', 'nom');
    }
}