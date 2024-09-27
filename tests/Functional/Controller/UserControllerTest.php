<?php declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests for the UserController
 * @covers UserController
 */
class UserControllerTest extends WebTestCase
{
    private readonly KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();

        // We need a user to access to some routes
        $testUser = static::getContainer()->get(UserRepository::class)->findOneBy(["email" => 'eleazar.ankunding@nolan.com']);
        self::assertNotNull($testUser, 'Test user should exist');

        $this->client->loginUser($testUser);
    }

    /**
     * @covers UserController::index
     * @return void
     */
    public function testIndexSuccess(): void
    {;
        $this->client->request('GET', '/user/index');

        self::assertResponseIsSuccessful();
    }

    /**
     * @covers UserController::show
     * @return void
     * @throws \JsonException
     */
    public function testShowSuccess(): void
    {
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        // We need to create a user before to start the test
        $testUserToShow = static::getContainer()->get(UserFactory::class)->create("testUserToShow@gmail.com", "1234567890", ["ROLE_USER"]);
        $entityManager->persist($testUserToShow);
        $entityManager->flush();

        $this->client->request('GET', '/user/show/'.$testUserToShow->getId());

        self::assertResponseIsSuccessful();

        // Assert that the response contains valid JSON and the correct user data
        $responseContent = $this->client->getResponse()->getContent();
        self::assertJson($responseContent);

        $responseData = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);

        // Assert that the response contains the correct data
        self::assertArrayHasKey('id', $responseData);
        self::assertArrayHasKey('email', $responseData);
        self::assertArrayHasKey("roles", $responseData);

        // Assert that user is successfully deleted
        $entityManager->remove($testUserToShow);
        $entityManager->flush();
    }

    /**
     * @covers UserController::add
     * @return void
     * @throws \JsonException
     */
    public function testAddSuccess(): void
    {
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        $getRequest = $this->client->request('GET', '/user/add');
        self::assertResponseIsSuccessful();

        $this->client->submit(
            $getRequest->filter("#user_form")->form(),
            [
                "user[email]" => "testAddedUser@gmail.com",
                "user[password]" => "testPassword"
            ]
        );

        /** @var User $lastAddedUser */
        $lastAddedUser = $entityManager->getRepository(User::class)->findLastUser();
        $this->assertNotNull($lastAddedUser);
        self::assertSame('testAddedUser@gmail.com', $lastAddedUser->getEmail());
        self::assertTrue(password_verify('testPassword', $lastAddedUser->getPassword()));
        self::assertContains("ROLE_USER", $lastAddedUser->getRoles());

        $responseContent = $this->client->getResponse()->getContent();
        self::assertJsonStringEqualsJsonString(json_encode($lastAddedUser->getId(), JSON_THROW_ON_ERROR), $responseContent);

        $entityManager->remove($lastAddedUser);
        $entityManager->flush();
    }

    /**
     * @covers UserController::edit
     * @return void
     * @throws \JsonException
     */
    public function testEditSuccess(): void
    {
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        // We need to create a user before to start the test
        $testUserToEdit = static::getContainer()->get(UserFactory::class)->create("testUserToEdit@gmail.com", "1234567890", ["ROLE_USER"]);
        $entityManager->persist($testUserToEdit);
        $entityManager->flush();

        $getRequest = $this->client->request('GET', '/user/edit/'.$testUserToEdit->getId());
        self::assertResponseIsSuccessful();

        $this->client->submit(
            $getRequest->filter("#user_form")->form(),
            [
                "user[email]" => "testUser@gmail.com",
                "user[password]" => "testPassword"
            ]
        );

        $testEditedUser = $entityManager->getRepository(User::class)->find($testUserToEdit->getId());
        $this->assertNotNull($testEditedUser);
        self::assertSame('testUser@gmail.com', $testEditedUser->getEmail());
        self::assertTrue(password_verify('testPassword', $testEditedUser->getPassword()));
        self::assertContains("ROLE_USER", $testEditedUser->getRoles());

        $responseContent = $this->client->getResponse()->getContent();
        self::assertJsonStringEqualsJsonString(json_encode($testEditedUser->getId(), JSON_THROW_ON_ERROR), $responseContent);

        // Removing the edited user
        $entityManager->remove($testEditedUser);
        $entityManager->flush();
    }

    /**
     * @covers UserController::delete
     * @return void
     * @throws \JsonException
     */
    public function testDeleteSuccess(): void
    {
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');

        // We need to create a user before to start the test
        $testUserToDelete = static::getContainer()->get(UserFactory::class)->create("testUserToDelete@gmail.com", "1234567890", ["ROLE_USER"]);
        $entityManager->persist($testUserToDelete);
        $entityManager->flush();

        $testUserToDeleteId = $testUserToDelete->getId();

        $this->client->request('GET', '/user/delete/'.$testUserToDelete->getId());
        self::assertResponseIsSuccessful();

        $entityManager->remove($testUserToDelete);
        $entityManager->flush();

        unset($testUserToDelete);

        $responseContent = $this->client->getResponse()->getContent();
        self::assertJsonStringEqualsJsonString(json_encode($testUserToDeleteId, JSON_THROW_ON_ERROR), $responseContent);

        // Assert that user is successfully deleted
        $deletedUser = $entityManager->find(User::class, $testUserToDeleteId);
        $this->assertNull($deletedUser);
    }
}
