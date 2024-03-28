<?php

namespace Actions;

class ChangeHoraireFormat
{
    public function changeHoraire(array $horaires): array
    {
        for ($i=0; $i < count($horaires); $i++) { 
            foreach ($horaires[$i] as $key => $value) {
                    if ($key == 'h_debut') {
                            $arrayheure = explode(':', $value);
                            $newheure = $arrayheure[0].'h'.$arrayheure[1];
                            $horaires[$i]['h_debut'] = $newheure;
                    }
                    elseif ($key == 'h_fin') {
                            $arrayheure = explode(':', $value);
                            $newheure = $arrayheure[0].'h'.$arrayheure[1];
                            $horaires[$i]['h_fin'] = $newheure;
                    }
            }
            $horaires[$i]['list'] = array();
            for ($j=1; $j < 24; $j++) { 
                    array_push($horaires[$i]['list'], $j.'h00');
                    array_push($horaires[$i]['list'], $j.'h30');
            }
        }

        return $horaires;
    }
}