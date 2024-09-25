<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testIndexReturn200AndRenderTemplate(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneBy(["email" => 'josefina.swaniawski@stark.biz']);

        $client->loginUser($testUser);

        $client->request('GET', '/user/index');

        self::assertResponseIsSuccessful();

        self::assertSelectorExists('.userRow', 'user1'); // Check if user1 exists in rendered template
        self::assertSelectorExists('.userRow', 'user2'); // Check if user2 exists in rendered template
    }
}
