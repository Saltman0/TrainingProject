<?php

namespace App\Services;

use App\Message\CreateNewsMessage;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Service used for generating news
 */
final readonly class NewsService
{
    public function __construct(private MessageBusInterface $messageBus) {}

    public function createNews(string $type, string $content): void
    {
        $message = new CreateNewsMessage($type, $content);
        $this->messageBus->dispatch($message);
    }
}