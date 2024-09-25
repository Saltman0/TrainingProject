<?php declare(strict_types=1);

namespace Functional\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers UserController
 */
class UserControllerTest extends WebTestCase
{
    public function testIndexReturn200AndRenderTemplate(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneBy(["email" => 'eleazar.ankunding@nolan.com']);
        $this->assertNotNull($testUser, 'Test user should exist');

        $client->loginUser($testUser);

        $client->request('GET', '/user/index');

        self::assertResponseIsSuccessful();
    }

    public function testShowReturn200AndRenderTemplate(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneBy(["email" => 'eleazar.ankunding@nolan.com']);

        $client->loginUser($testUser);

        $client->request('GET', '/user/index');

        self::assertResponseIsSuccessful();
    }
}
