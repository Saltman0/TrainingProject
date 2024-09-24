<?php

namespace App\Factory;

use App\Entity\Cinema;
use App\Entity\Hall;

class HallFactory
{
    public function create(int $number, string $projectionQuality, Cinema $cinema): Hall
    {
        $hall = new Hall();
        $hall->setNumber($number);
        $hall->setProjectionQuality($projectionQuality);
        $hall->setCinema($cinema);

        return $hall;
    }
}