<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Factory\NewsFactory;
use App\Message\CreateNewsMessage;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
#[WithMonologChannel("news")]
final readonly class CreateNewsMessageHandler
{
    public function __construct(private NewsFactory $newsFactory,
                                private EntityManagerInterface $entityManager,
                                private LoggerInterface $logger) {}

    public function __invoke(CreateNewsMessage $message): void
    {
        $news = $this->newsFactory->create($message->getType(), $message->getContent());
        $this->entityManager->persist($news);
        $this->entityManager->flush();
        $this->logger->info("Created news with id {$news->getId()}");
    }
}
