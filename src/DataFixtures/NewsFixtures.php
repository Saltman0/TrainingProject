<?php

namespace App\DataFixtures;

use App\Factory\NewsFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NewsFixtures extends Fixture implements OrderedFixtureInterface
{
    public const string NEWS_REFERENCE = 'news';

    public function __construct(private readonly NewsFactory $newsFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $news = $this->newsFactory->create($faker->title(), $faker->text());
        $manager->persist($news);
        $manager->flush();

        $this->addReference(self::NEWS_REFERENCE, $news);
    }

    public function getOrder(): int
    {
        return 3;
    }
}
