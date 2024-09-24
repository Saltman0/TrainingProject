<?php

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Movie;

class MovieFactory
{
    public function create(string $title, string $description, int $minimumAge, bool $favorite, Category $category, array $ratings, array $sessions): Movie
    {
        $movie = new Movie();
        $movie->setTitle($title);
        $movie->setDescription($description);
        $movie->setMinimumAge($minimumAge);
        $movie->setFavorite($favorite);
        $movie->setCategory($category);
        foreach ($ratings as $rating) {
            $movie->addRating($rating);
        }
        foreach ($sessions as $session) {
            $movie->addSession($session);
        }

        return $movie;
    }
}