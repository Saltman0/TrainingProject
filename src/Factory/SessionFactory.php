<?php

namespace App\Factory;

use App\Entity\Hall;
use App\Entity\Movie;
use App\Entity\Session;
use DateTime;

class SessionFactory
{
    public function create(DateTime $startTime, DateTime $endTime, int $price, Movie $movie, Hall $hall): Session
    {
        $session = new Session();
        $session->setStartTime($startTime);
        $session->setEndTime($endTime);
        $session->setPrice($price);
        $session->setMovie($movie);
        $session->setHall($hall);

        return $session;
    }
}