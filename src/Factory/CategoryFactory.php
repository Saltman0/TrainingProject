<?php

namespace App\Factory;

use App\Entity\Category;

class CategoryFactory
{
    public function create(string $name, array $movies): Category
    {
        $category = new Category();
        $category->setName($name);
        foreach ($movies as $movie) {
            $category->addMovie($movie);
        }

        return $category;
    }
}