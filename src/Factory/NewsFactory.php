<?php

namespace App\Factory;

use App\Entity\Cinema;
use App\Entity\Hall;
use App\Entity\News;
use DateTime;

class NewsFactory
{
    public function create(string $type, string $description): News
    {
        $news = new News();
        $news->setType($type);
        $news->setDescription($description);

        return $news;
    }
}