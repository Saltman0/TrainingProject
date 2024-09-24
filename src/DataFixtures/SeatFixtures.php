<?php

namespace App\DataFixtures;

use App\Factory\SeatFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeatFixtures extends Fixture implements DependentFixtureInterface
{
    public const string SEAT_REFERENCE = "seat";

    public function __construct(private readonly SeatFactory $seatFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $hall = $this->getReference(HallFixtures::HALL_REFERENCE);

        $seat = $this->seatFactory->create($faker->randomLetter(), $faker->numberBetween(1, 30), $hall);
        $manager->persist($seat);
        $manager->flush();

        $this->addReference(self::SEAT_REFERENCE, $seat);
    }

    public function getDependencies(): array
    {
        return [
            HallFixtures::class
        ];
    }
}
