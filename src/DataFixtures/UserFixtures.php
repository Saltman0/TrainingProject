<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public const string USER_REFERENCE = 'user';

    public function __construct(private readonly UserFactory $userFactory) {}

    public function load(ObjectManager $manager): void
    {
        $roles = ["ROLE_USER", "ROLE_ADMIN"];
        $randomKey = array_rand($roles);

        $faker = Factory::create();

        $user = $this->userFactory->createUser($faker->email(), $faker->password(), [$roles[$randomKey]], []);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user);
    }

    public function getOrder(): int
    {
        // We want UserFixtures executes first.
        return 1;
    }
}
