<?php

namespace App\Controller;

use App\Entity\TicketComment;
use App\Controller\Trait\RoleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/ticket/comment', name: 'ticketComment-')]
class TicketCommentController extends AbstractController
{
    use RoleTrait;



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
