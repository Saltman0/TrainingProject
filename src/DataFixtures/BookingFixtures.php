<?php

namespace App\DataFixtures;

use App\Factory\BookingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public const string BOOKING_REFERENCE = "booking";

    public function __construct(private readonly BookingFactory $bookingFactory) {}

    public function load(ObjectManager $manager): void
    {
        $user = $this->getReference(UserFixtures::USER_REFERENCE);
        $session = $this->getReference(SessionFixtures::SESSION_REFERENCE);

        $booking = $this->bookingFactory->create($user, $session);
        $manager->persist($booking);
        $manager->flush();

        $this->addReference(self::BOOKING_REFERENCE, $booking);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SessionFixtures::class
        ];
    }
}
