<?php

namespace App\Factory;

use App\Entity\Booking;
use App\Entity\Rating;
use App\Entity\User;

class UserFactory
{
    /**
     * @param string|null $email
     * @param string|null $password
     * @param array $roles
     * @param Booking[] $bookings
     * @param Rating[] $ratings
     * @return User
     */
    public function create(?string $email = null, ?string $password = null, array $roles = [], array $bookings = [], array $ratings = []): User
    {
        $user = new User();

        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($roles);
        foreach ($bookings as $booking) {
            $user->addBooking($booking);
        }
        foreach ($ratings as $rating) {
            $user->addRating($rating);
        }

        return $user;
    }
}