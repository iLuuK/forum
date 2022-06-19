<?php

namespace App\Controller\Trait;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reaction;
use App\Entity\TicketComment;
use App\Entity\Ticket;
use App\Entity\Category;

Trait DeleteTrait
{
    private function deleteReaction(EntityManagerInterface $entityManager, Reaction $reaction){
        $reaction->setIsDelete(true);
        $reaction->setUpdatedAt();
        
        $entityManager->persist($reaction);
        $entityManager->flush();
    }

    private function deleteTicketComment(EntityManagerInterface $entityManager, TicketComment $ticketComment){
        $ticketComment->setIsDelete(true);
        $ticketComment->setUpdatedAt();

        $entityManager->persist($ticketComment);
        $entityManager->flush();
    }

    private function deleteTicket(EntityManagerInterface $entityManager, Ticket $ticket){
        $ticket->setIsDelete(true);
        $ticket->setUpdatedAt();
        $entityManager->persist($ticket);
        $entityManager->flush();

        foreach ($ticket->getTicketComments()->toArray() as $ticketComment) {
            $this->deleteTicketComment($entityManager, $ticketComment);
        }
        foreach ($ticket->getReactions()->toArray() as $reaction) {
            $this->deleteReaction($entityManager, $reaction);
        }
    }

    private function deleteCategory(EntityManagerInterface $entityManager, Category $category){
        foreach ($category->getTickets()->toArray() as $ticket) {
            $this->deleteTicket($entityManager, $ticket);
        }
        $category->setIsDeleted(true);
        $category->setUpdatedAt();
        $entityManager->persist($category);
        $entityManager->flush();
    }
}