<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Controller\Trait\RoleTrait;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/user', name: 'user-')]
class UserController extends AbstractController
{
    use RoleTrait;

    public function __construct(private SluggerInterface $slugger)
    {
    }

    #[Route('/', name: 'main')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $user->setUpdatedAt();
        $user->computeSlug($this->slugger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/index.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    #[Route('/delete-me', name: 'delete-me')]
    public function deleteMe(EntityManagerInterface $entityManager): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        /** @var User $user */
        $user = $this->getUser();
        $user = $this->deleteUser($user);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('authentication-logout');
    }

    private function deleteUser(User $user): User{
        $user->setIsClose(true);
        //TODO anonymize user ?
        return $user;
    }

    private function checkIsNotUser(User $user): ?Response{
        /** @var User $actualuser */
        $actualuser = $this->getUser();
        if($actualuser->getUsername() == $user->getUsername()){
            return $this->redirectToRoute('user-list');
        }
        return null;
    }

    #[Route('/{slug}/delete', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, User $user): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }
        if($response = $this->checkIsNotUser($user)){
            return $response;
        }

        $user = $this->deleteUser($user);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user-list');
    }

    #[Route('/{slug}/ban', name: 'ban')]
    public function ban(EntityManagerInterface $entityManager, User $user): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }
        if($response = $this->checkIsNotUser($user)){
            return $response;
        }

        $user->setIsBan(true);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user-list');
    }

    #[Route('/{slug}/unban', name: 'unban')]
    public function unban(EntityManagerInterface $entityManager, User $user): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }
        if($response = $this->checkIsNotUser($user)){
            return $response;
        }
        $user->setIsBan(false);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user-list');
    }

    #[Route('/list', name: 'list')]
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findBy(
                [],
                ['created_at' => 'desc'],
                12,
                0
            ),
        ]);
    }
}