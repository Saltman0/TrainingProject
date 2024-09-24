<?php

namespace App\Factory;

use App\Entity\Hall;
use App\Entity\Seat;

class SeatFactory
{
    public function create(string $row, int $number, Hall $hall): Seat
    {
        $seat = new Seat();
        $seat->setRow($row);
        $seat->setNumber($number);
        $seat->setHall($hall);

        return $seat;
    }
}