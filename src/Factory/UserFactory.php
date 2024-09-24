<?php

namespace App\Factory;

use App\Entity\User;

class UserFactory
{
    public function create(?string $email = null, ?string $password = null, array $roles = [], array $bookings = []): User
    {
        $user = new User();

        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($roles);
        foreach ($bookings as $booking) {
            $user->addBooking($booking);
        }

        return $user;
    }
}