<?php

namespace App\Factory;

use App\Entity\Booking;
use App\Entity\Session;
use App\Entity\User;

class BookingFactory
{
    public function create(User $user, Session $session): Booking
    {
        $booking = new Booking();
        $booking->setUser($user);
        $booking->setSession($session);

        return $booking;
    }
}