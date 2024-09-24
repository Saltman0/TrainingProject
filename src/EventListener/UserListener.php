<?php

namespace App\EventListener;

use App\Entity\User;
use App\Factory\NewsFactory;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: Events::postPersist, entity: User::class)]
#[AsEntityListener(event: Events::postRemove, method: Events::postRemove, entity: User::class)]
class UserListener
{
    public function __construct(private readonly NewsFactory $newsFactory) {}

    public function postPersist(User $user, PostPersistEventArgs $event): void
    {
        $news = $this->newsFactory->create(User::class, "L'utilisateur ".$user->getEmail()." a été ajouté !");
        $event->getObjectManager()->persist($news);
        $event->getObjectManager()->flush();
    }

    public function postRemove(User $user, PostRemoveEventArgs $event): void
    {
        $news = $this->newsFactory->create(User::class, "L'utilisateur ".$user->getEmail()." a été supprimé !");
        $event->getObjectManager()->persist($news);
        $event->getObjectManager()->flush();
    }
}