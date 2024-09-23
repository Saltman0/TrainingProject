<?php

namespace App\DataFixtures;

use App\Factory\HallFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HallFixtures extends Fixture implements DependentFixtureInterface
{
    public const string HALL_REFERENCE = 'hall';

    public function __construct(private readonly HallFactory $hallFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $cinema = $this->getReference(CinemaFixtures::CINEMA_REFERENCE);

        $hall = $this->hallFactory->create($faker->numberBetween(1, 10), "3D, 4DX, none", $cinema);
        $manager->persist($hall);
        $manager->flush();

        $this->addReference(self::HALL_REFERENCE, $hall);
    }

    public function getDependencies(): array
    {
        return [
            CinemaFixtures::class
        ];
    }
}
