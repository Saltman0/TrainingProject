<?php

namespace App\DataFixtures;

use App\Factory\SessionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    public const string SESSION_REFERENCE = 'session';

    public function __construct(private readonly SessionFactory $sessionFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $movie = $this->getReference(MovieFixtures::MOVIE_REFERENCE);
        $hall = $this->getReference(HallFixtures::HALL_REFERENCE);

        $session = $this->sessionFactory->create($faker->dateTimeBetween(), $faker->dateTime(), $faker->numberBetween(5, 20), $movie, $hall);
        $manager->persist($session);
        $manager->flush();

        $this->addReference(self::SESSION_REFERENCE, $session);
    }

    public function getDependencies(): array
    {
        return [
            MovieFixtures::class,
            HallFixtures::class
        ];
    }
}
