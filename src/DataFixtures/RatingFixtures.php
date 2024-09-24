<?php

namespace App\DataFixtures;

use App\Factory\RatingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RatingFixtures extends Fixture implements DependentFixtureInterface
{
    public const string RATING_REFERENCE = 'rating';

    public function __construct(private readonly RatingFactory $ratingFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $movie = $this->getReference(MovieFixtures::MOVIE_REFERENCE);
        $user = $this->getReference(UserFixtures::USER_REFERENCE);

        $rating = $this->ratingFactory->create($faker->numberBetween(0, 5), $faker->boolean(), $movie, $user);
        $manager->persist($rating);
        $manager->flush();

        $this->addReference(self::RATING_REFERENCE, $rating);
    }

    public function getDependencies(): array
    {
        return [
            MovieFixtures::class,
            UserFixtures::class
        ];
    }
}
