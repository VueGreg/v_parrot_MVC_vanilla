<?php

namespace Models;


class VehiculesModel extends Model
{
    public function belongsToMarkAnnonces(): array
    {
        return $this->relationships()->belongsTo('annonces', 'marque');
    }

    public function belongsToModelAnnonces(): array
    {
        return $this->relationships()->belongsTo('annonces', 'modele');
    }
}