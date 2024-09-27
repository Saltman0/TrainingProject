<?php

namespace App\Tests\Unit\Factory;

use App\Entity\Booking;
use App\Entity\Rating;
use App\Factory\UserFactory;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    private readonly UserFactory $userFactory;

    public function setUp(): void
    {
        $this->userFactory = new UserFactory();
    }

    /**
     * @covers UserFactory::create
     * @return void
     */
    public function testCreate(): void
    {
        $data = [
            "email" => "test@example.com",
            "password" => "01234567890",
            "roles" => ["ROLE_USER"],
            "bookings" => [new Booking(), new Booking()],
            "ratings" => [new Rating(), new Rating()]
        ];

        $user = $this->userFactory->create($data["email"], $data["password"], $data["roles"], $data["bookings"], $data["ratings"]);

        $this->assertEquals($data["email"], $user->getEmail());
        $this->assertEquals($data["password"], $user->getPassword());
        $this->assertEquals($data["roles"], $user->getRoles());
        $this->assertEquals($data["bookings"], $user->getBookings()->toArray());
        $this->assertEquals($data["ratings"], $user->getRatings()->toArray());
    }
}
