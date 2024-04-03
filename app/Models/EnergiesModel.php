<?php

namespace Models;

class EnergiesModel extends Model
{
    public function belongsToAnnonces()
    {
        return $this->relationships()->belongsTo('annonces', 'nom');
    }
}