<?php

namespace App\Factory;

use App\Entity\Booking;
use App\Entity\BookingSeat;
use App\Entity\Seat;

class BookingSeatFactory
{
    public function create(Booking $booking, Seat $seat): BookingSeat
    {
        $bookingSeat = new BookingSeat();
        $bookingSeat->setBooking($booking);
        $bookingSeat->setSeat($seat);

        return $bookingSeat;
    }
}