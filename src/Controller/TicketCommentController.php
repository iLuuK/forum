<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketComment;
use App\Entity\User;
use App\Controller\Trait\RoleTrait;
use App\Repository\TicketCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\TicketFormType;


#[Route('/ticket/comment', name: 'ticketComment-')]
class TicketCommentController extends AbstractController
{
    use RoleTrait;

    #[Route('/{slug}/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }

        $ticketComment = new TicketComment();

        $form = $this->createForm(TicketCommentFormType::class, $ticketComment);
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

    #[Route('/{id}/delete', name: 'delete')]
    public function close(EntityManagerInterface $entityManager, TicketComment $ticketComment): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }

        $ticketComment->setIsDelete(true);
        $ticketComment->setUpdatedAt();

        $entityManager->persist($ticketComment);
        $entityManager->flush();

        return $this->redirectToRoute('ticket-detail', ['slug' => $ticketComment->getTicket()->getSlug()]);
    }
}
