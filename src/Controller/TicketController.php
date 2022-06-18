<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Category;
use App\Entity\User;
use App\Controller\Trait\RoleTrait;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\TicketFormType;

#[Route('/ticket', name: 'ticket-')]
class TicketController extends AbstractController
{
    use RoleTrait;

    #[Route('/', name: 'main')]
    public function index(TicketRepository $ticketRepository): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        return $this->render('ticket/index.html.twig', [
            'tickets' => $ticketRepository->findLast()
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }

        $ticket = new Ticket();
        $form = $this->createForm(TicketFormType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($ticket->getTitle())->lower();
            $ticket->setSlug($slug);

            /** @var User $user */
            $user = $this->getUser();
            $ticket->setAuthor($user);
            $ticket->setPublishedDate(new \DateTimeImmutable());
            $entityManager->persist($ticket);
            $entityManager->flush();
            return $this->redirectToRoute('ticket-main');
        }
        return $this->render('ticket/add.html.twig', [
            'ticketForm' => $form->createView()
        ]);
    }

    #[Route('/{slug}/tickets', name: 'category')]
    public function category(TicketRepository $ticketRepository, Category $category): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }

        return $this->render('ticket/category.html.twig', [
            'tickets' => $ticketRepository->findByCategory($category)
        ]);
    }

    #[Route('/{slug}', name: 'detail')]
    public function detail(Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        return $this->render('ticket/detail.html.twig', [
            'ticket' => $ticket
        ]);
    }

    #[Route('/{slug}/delete', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }

        $ticket->setIsClose(true);

        $entityManager->persist($ticket);
        $entityManager->flush();

        return $this->redirectToRoute('ticket-main');
    }

}
