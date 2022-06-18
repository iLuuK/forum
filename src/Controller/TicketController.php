<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Controller\Trait\RoleTrait;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            'tickets' => $ticketRepository->findBy(
                [],
                ['created_at' => 'desc'],
                10,
                0
            ),
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
}
