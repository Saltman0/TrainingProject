<?php

namespace App\DataFixtures;

use App\Factory\BookingFactory;
use App\Factory\BookingSeatFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookingSeatFixtures extends Fixture implements DependentFixtureInterface
{
    public const string BOOKING_SEAT_REFERENCE = "bookingSeat";

    public function __construct(private readonly BookingSeatFactory $bookingSeatFactory) {}

    public function load(ObjectManager $manager): void
    {
        $booking = $this->getReference(BookingFixtures::BOOKING_REFERENCE);
        $seat = $this->getReference(SeatFixtures::SEAT_REFERENCE);

        $bookingSeat = $this->bookingSeatFactory->create($booking, $seat);
        $manager->persist($bookingSeat);
        $manager->flush();

        $this->addReference(self::BOOKING_SEAT_REFERENCE, $bookingSeat);
    }

    public function getDependencies(): array
    {
        return [
            BookingFixtures::class,
            SeatFixtures::class
        ];
    }
}
