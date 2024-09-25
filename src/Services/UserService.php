<?php declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

readonly class UserService
{
    public function __construct(private UserRepository         $userRepository,
                                private CacheItemPoolInterface $redisCache) {}

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