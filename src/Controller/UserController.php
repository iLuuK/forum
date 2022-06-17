<?php

namespace App\Controller;

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
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/index.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}