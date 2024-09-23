<?php

namespace App\Factory;

use App\Entity\Hall;
use App\Entity\Incident;

class IncidentFactory
{
    public function create(string $type, string $description, Hall $hall): Incident
    {
        $incident = new Incident();

        $incident->setType($type);
        $incident->setDescription($description);
        $incident->setHall($hall);

        return $incident;
    }
}