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

#[Route('/user', name: 'user-')]
class UserController extends AbstractController
{
    use RoleTrait;

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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/index.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    #[Route('/delete', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        /** @var User $user */
        $user = $this->getUser();
        $user->setUsername("deleted");
        $user->setFirstname("deleted");
        $user->setLastname("deleted");
        $user->setEmail("deleted");
        $user->setPassword("deleted");
        $user->setAddress("deleted");
        $user->setPostalCode("deleted");
        $user->setCity("deleted");
        $user->setPhoneNumber("deleted");
        $user->setRoles(["deleted"]);
        $user->setSlug("deleted");
        $user->setIsClose(true);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('authentication-logout');
    }
}