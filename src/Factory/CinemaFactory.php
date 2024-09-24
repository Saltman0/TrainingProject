<?php

namespace App\Factory;

use App\Entity\Cinema;
use App\Entity\Hall;
use DateTime;

class CinemaFactory
{
    /**
     * @param string $name
     * @param string $adress
     * @param string $phoneNumber
     * @param DateTime $openHour
     * @param DateTime $closeHour
     * @param Hall[] $halls
     * @return Cinema
     */
    public function create(string $name, string $adress, string $phoneNumber, DateTime $openHour, DateTime $closeHour, array $halls): Cinema
    {
        $cinema = new Cinema();
        $cinema->setName($name);
        $cinema->setAdress($adress);
        $cinema->setPhoneNumber($phoneNumber);
        $cinema->setOpenHour($openHour);
        $cinema->setCloseHour($closeHour);
        foreach ($halls as $hall) {
            $cinema->addHall($hall);
        }

        return $cinema;
    }
}