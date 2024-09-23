<?php

namespace App\DataFixtures;

use App\Factory\CinemaFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CinemaFixtures extends Fixture implements OrderedFixtureInterface
{
    public const string CINEMA_REFERENCE = "cinema";

    public function __construct(private readonly CinemaFactory $cinemaFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $cinema = $this->cinemaFactory->create($faker->domainName(), $faker->address(), $faker->phoneNumber(), new DateTime("2024-09-23 08:00:00"), new DateTime("2024-09-23 23:00:00"), []);
        $manager->persist($cinema);
        $manager->flush();

        $this->addReference(self::CINEMA_REFERENCE, $cinema);
    }

    public function getOrder(): int
    {
        // We want to load this fixture after UserFixtures
        return 2;
    }
}
