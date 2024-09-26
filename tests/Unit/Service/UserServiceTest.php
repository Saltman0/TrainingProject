<?php

namespace App\Tests\Unit\Service;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @covers UserService
 */
class UserServiceTest extends TestCase
{
    private readonly UserFactory $userFactory;
    private readonly UserRepository $userRepository;
    private readonly EntityManagerInterface $entityManager;
    private readonly CacheItemPoolInterface $redisCache;
    private readonly UserService $userService;

    public function setUp(): void
    {
        $this->userFactory = $this->createMock(UserFactory::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->redisCache = $this->createMock(CacheItemPoolInterface::class);
        $this->userService = new UserService($this->userFactory, $this->userRepository, $this->entityManager, $this->redisCache);
    }

    /**
     * @covers UserService::createUser
     * @return void
     */
    public function testCreateUser(): void
    {
        $data = [
            "email" => "test@example.com",
            "password" => "01234567890",
            "roles" => ["ROLE_USER"],
            "bookings" => [],
            "ratings" => []
        ];
        $user = $this->createMock(User::class);

        $this->userFactory->expects($this->once())
            ->method('create')
            ->with($data["email"], $data["password"], $data["roles"], $data["bookings"], $data["ratings"])
            ->willReturn($user);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $result = $this->userService->createUser($data["email"], $data["password"], $data["roles"], $data["bookings"], $data["ratings"]);

        $this->assertSame($user, $result);
    }

    /**
     * @covers UserService::getAllUsers
     * @return void
     */
    public function testGetAllUser(): void
    {
        $cacheItem = $this->createMock(CacheItemInterface::class);

        $this->redisCache->expects($this->once())
            ->method('getItem')
            ->with("getAllUsers")
            ->willReturn($cacheItem);

        // Mock data to be returned from the cache
        $users = [
            $this->createMock(User::class),
            $this->createMock(User::class)
        ];

        // Set up the redisCache mock to return a cache item that hits
        $this->redisCache->expects($this->once())
            ->method('getItem')
            ->with('getAllUsers')
            ->willReturn($cacheItem);

        $cacheItem->expects($this->once())
            ->method('isHit')
            ->willReturn(true);

        $cacheItem->expects($this->once())
            ->method('get')
            ->willReturn($users);

        $result = $this->userService->getAllUsers();

        $this->assertSame($users, $result);
    }
}
