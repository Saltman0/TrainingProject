<?php declare(strict_types=1);

namespace App\Tests\MessageHandler;

use App\Entity\News;
use App\Factory\NewsFactory;
use App\Message\CreateNewsMessage;
use App\MessageHandler\CreateNewsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @covers CreateNewsMessageHandler
 */
final class CreateNewsMessageHandlerTest extends TestCase
{
    private readonly MockObject $newsFactory;
    private readonly MockObject $entityManagerMock;
    private readonly MockObject $loggerMock;

    public function setUp(): void
    {
        $this->newsFactory = $this->createMock(NewsFactory::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
    }

    public function testCreateNewsMessageIsHandledCorrectly(): void
    {
        $handler = new CreateNewsMessageHandler($this->newsFactory, $this->entityManagerMock, $this->loggerMock);

        $messageMock = $this->createMock(CreateNewsMessage::class);
        $newsMock = $this->createMock(News::class);

        // Set up expectations for the message
        $messageMock->method('getType')->willReturn('Type');
        $messageMock->method('getContent')->willReturn('Content');

        $this->newsFactory->expects($this->once())->method('create')->with("Type", "Content")->willReturn($newsMock);
        $this->entityManagerMock->expects($this->once())->method('persist')->with($newsMock);
        $this->entityManagerMock->expects($this->once())->method('flush');
        $newsMock->method('getId')->willReturn(123);
        $this->loggerMock->expects($this->once())
            ->method('info')
            ->with('Created news with id 123');

        $handler->__invoke($messageMock);
    }
}
