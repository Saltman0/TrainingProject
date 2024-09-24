<?php

namespace App\EventListener;

use App\Entity\User;
use App\Services\NewsService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: Events::postPersist, entity: User::class)]
#[AsEntityListener(event: Events::postRemove, method: Events::postRemove, entity: User::class)]
final readonly class UserListener
{
    public const string USER_TYPE = "user";
    public function __construct(private NewsService $newsService) {}

    public function postPersist(User $user): void
    {
        $this->newsService->createNews(self::USER_TYPE, "L'utilisateur ".$user->getEmail()." a été ajouté !");
    }

    public function postRemove(User $user): void
    {
        $this->newsService->createNews(self::USER_TYPE, "L'utilisateur ".$user->getEmail()." a été supprimé !");
    }
}