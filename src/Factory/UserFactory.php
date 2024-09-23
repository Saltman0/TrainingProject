<?php

namespace App\Factory;

use App\Entity\User;

class UserFactory
{
    public function createUser(): User
    {
        return new User;
    }
}