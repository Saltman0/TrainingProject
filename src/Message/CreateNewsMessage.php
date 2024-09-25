<?php

namespace App\Message;

/**
 * Message used for creating news in the database
 */
class CreateNewsMessage
{
    public function __construct(private string $type, private string $content) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
