<?php declare(strict_types=1);

namespace Unit\EventListener;

use App\Entity\User;
use App\EventListener\UserListener;
use App\Services\NewsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers UserListener
 */
final class UserListenerTest extends TestCase
{
    private readonly MockObject $newsServiceMock;
    private readonly UserListener $userListener;
    public function setUp(): void
    {
        $this->newsServiceMock = $this->createMock(NewsService::class);
        $this->userListener = new UserListener($this->newsServiceMock);
    }

    public function testPostPersist(): void
    {
        $userMock = $this->createMock(User::class);
        $userMock->method('getEmail')->willReturn("example@gmail.com");

        $this->newsServiceMock->expects($this->once())
            ->method("createNews")
            ->with(UserListener::USER_TYPE, "L'utilisateur example@gmail.com a été ajouté !");

        $this->userListener->postPersist($userMock);
    }

    public function testPostRemove(): void
    {
        $userMock = $this->createMock(User::class);
        $userMock->method('getEmail')->willReturn("example@gmail.com");

        $this->newsServiceMock->expects($this->once())
            ->method("createNews")
            ->with(
                $this->equalTo(UserListener::USER_TYPE),
                $this->equalTo("L'utilisateur example@gmail.com a été supprimé !")
            );

        $this->userListener->postRemove($userMock);
    }
}
