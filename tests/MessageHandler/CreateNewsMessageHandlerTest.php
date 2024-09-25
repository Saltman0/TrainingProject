<?php declare(strict_types=1);

namespace App\Tests\MessageHandler;

use App\Entity\News;
use App\Factory\NewsFactory;
use App\Message\CreateNewsMessage;
use App\MessageHandler\CreateNewsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @covers CreateNewsMessageHandler
 */
class CreateNewsMessageHandlerTest extends TestCase
{
    public function testCreateNewsMessageIsHandledCorrectly(): void
    {
        $newsFactoryMock = $this->createMock(NewsFactory::class);
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $loggerMock = $this->createMock(LoggerInterface::class);

        $handler = new CreateNewsMessageHandler($newsFactoryMock, $entityManagerMock, $loggerMock);

        $messageMock = $this->createMock(CreateNewsMessage::class);
        $newsMock = $this->createMock(News::class);

        // Set up expectations for the message
        $messageMock->method('getType')->willReturn('Type');
        $messageMock->method('getContent')->willReturn('Content');

        $newsFactoryMock->expects($this->once())->method('create')->with("Type", "Content")->willReturn($newsMock);
        $entityManagerMock->expects($this->once())->method('persist')->with($newsMock);
        $entityManagerMock->expects($this->once())->method('flush');
        $newsMock->method('getId')->willReturn(123);
        $loggerMock->expects($this->once())
            ->method('info')
            ->with('Created news with id 123');
        $loggerMock->expects($this->once())->method('info')->with();

        $handler->__invoke($messageMock);
    }
}
