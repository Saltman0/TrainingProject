<?php

namespace App\DataFixtures;

use App\Factory\IncidentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IncidentFixtures extends Fixture implements DependentFixtureInterface
{
    public const string INCIDENT_REFERENCE = "incident";

    public function __construct(private readonly IncidentFactory $incidentFactory) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $hall = $this->getReference(HallFixtures::HALL_REFERENCE);

        $incident = $this->incidentFactory->create($faker->title(), $faker->text(), $hall);
        $manager->persist($incident);
        $manager->flush();

        $this->addReference(self::INCIDENT_REFERENCE, $incident);
    }

    public function getDependencies(): array
    {
        return [
            HallFixtures::class
        ];
    }
}
