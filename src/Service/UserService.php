<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

readonly class UserService
{
    public function __construct(private UserFactory            $userFactory,
                                private UserRepository         $userRepository,
                                private EntityManagerInterface $entityManager,
                                private CacheItemPoolInterface $redisCache) {}

    public function createUser(string $email, string $password, array $roles, array $bookings, array $ratings): User
    {
        $user = $this->userFactory->create($email, $password, $roles, $bookings, $ratings);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * Return all users from Doctrine or Redis
     * @return User[]
     */
    public function getAllUsers(): array
    {
        try {
            $userItem = $this->redisCache->getItem('getAllUsers');

            if (!$userItem->isHit()) {
                $userItem->set($this->userRepository->findAll());
                $userItem->expiresAfter(3600);
                $this->redisCache->save($userItem);
            }

            return $userItem->get();
        } catch (InvalidArgumentException) {
            return $this->userRepository->findAll();
        }
    }
}