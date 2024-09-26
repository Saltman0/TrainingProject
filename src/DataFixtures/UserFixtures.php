<?php

namespace App\DataFixtures;

use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public const string USER_REFERENCE = 'user';

    public function __construct(private readonly UserService $userService) {}

    public function load(ObjectManager $manager): void
    {
        $roles = ["ROLE_USER", "ROLE_ADMIN"];
        $randomKey = array_rand($roles);

        $faker = Factory::create();

        $user = $this->userService->createUser($faker->email(), $faker->password(), [$roles[$randomKey]], [], []);

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
