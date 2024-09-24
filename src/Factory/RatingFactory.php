<?php

namespace App\Factory;

use App\Entity\Movie;
use App\Entity\Rating;
use App\Entity\User;

class RatingFactory
{
    public function create(int $number, bool $validated, Movie $movie, User $user): Rating
    {
        $rating = new Rating();
        $rating->setNumber($number);
        $rating->setValidated($validated);
        $rating->setMovie($movie);
        $rating->setUser($user);

        return $rating;
    }
}