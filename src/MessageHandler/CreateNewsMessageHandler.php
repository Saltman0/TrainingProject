<?php

namespace App\MessageHandler;

use App\Factory\NewsFactory;
use App\Message\CreateNewsMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateNewsMessageHandler
{
    public function __construct(private NewsFactory $newsFactory, private EntityManagerInterface $entityManager) {}

    public function __invoke(CreateNewsMessage $message): void
    {
        $news = $this->newsFactory->create($message->getType(), $message->getContent());
        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }
}
