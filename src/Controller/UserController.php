<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Form\UserType;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/index', name: 'app_user_index', methods: ['GET'])]
    public function index(UserService $userService): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userService->getAllUsers(),
        ]);
    }

    #[Route('/show/{user}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, SerializerInterface $serializer): Response
    {
        return new JsonResponse($serializer->serialize($user, 'json', ["groups" => ["api"]]), 200, [], true);
    }

    #[Route('/add', name: 'app_user_add', methods: ['GET', 'POST'])]
    public function add(Request $request, UserFactory $userFactory, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $userFactory->create();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );

            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse($user->getId(), Response::HTTP_CREATED);

        }

        return $this->render('user/add.html.twig', [
            "userForm" => $form->createView()
        ]);
    }

    #[Route('/edit/{user}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );

            $user->setRoles(['ROLE_USER']);

            $entityManager->flush();

            return new JsonResponse($user->getId(), Response::HTTP_ACCEPTED);

        }

        return $this->render('user/edit.html.twig', [
            "userForm" => $form->createView()
        ]);
    }

    #[Route('/delete/{user}', name: 'app_user_delete', methods: ['GET'])]
    public function delete(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $userId = $user->getId();

        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse($userId);
    }
}
