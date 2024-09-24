<?php

namespace App\DataFixtures;

use App\Factory\MovieFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public const string MOVIE_REFERENCE = "movie";

    public function __construct(private readonly MovieFactory $movieFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE);

        $movie = $this->movieFactory->create($faker->title(), $faker->paragraph(1), $faker->numberBetween(0, 18), $faker->boolean(), $category, [], []);
        $manager->persist($movie);
        $manager->flush();

        $this->addReference(self::MOVIE_REFERENCE, $movie);
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }
}
