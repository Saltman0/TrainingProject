<?php

namespace App\Services;

use App\Message\CreateNewsMessage;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Service used for news
 */
final readonly class NewsService
{
    public function __construct(private MessageBusInterface $messageBus) {}

    /**
     * Generate an asynchronous message for creating a news
     * @param string $type
     * @param string $content
     * @return void
     */
    public function createNews(string $type, string $content): void
    {
        $message = new CreateNewsMessage($type, $content);
        $this->messageBus->dispatch($message);
    }
}