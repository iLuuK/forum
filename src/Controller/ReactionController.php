<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Reaction;
use App\Entity\User;
use App\Controller\Trait\RoleTrait;
use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;

#[Route('/reaction', name: 'reaction-')]
class ReactionController extends AbstractController
{
    use RoleTrait;

    #[Route('/{slug}/like', name: 'like')]
    public function like(ReactionRepository $reactionRepository, EntityManagerInterface $entityManager, Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        /** @var User $user */
        $user = $this->getUser();
        if($this->checkReactionExist($reactionRepository, $user, $ticket) == false){
            $reaction = new Reaction();
            $reaction->setIsLike(true);
            $reaction->setTicket($ticket);
            $reaction->setUser($user);
            $entityManager->persist($reaction);
            $entityManager->flush();
        }
        return $this->redirectToRoute('ticket-detail', ['slug' => $ticket->getSlug()]);
    }

    #[Route('/{slug}/dislike', name: 'dislike')]
    public function dislike(ReactionRepository $reactionRepository, EntityManagerInterface $entityManager, Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        /** @var User $user */
        $user = $this->getUser();
        if($this->checkReactionExist($reactionRepository, $user, $ticket) == false){
            $reaction = new Reaction();
            $reaction->setIsLike(false);
            $reaction->setTicket($ticket);
            $reaction->setUser($user);
            $entityManager->persist($reaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ticket-detail', ['slug' => $ticket->getSlug()]);
    }

    private function checkReactionExist(ReactionRepository $reactionRepository, User $user, Ticket $ticket): bool{
        $reaction = $reactionRepository->findSame($user, $ticket);
        return $reaction != null;
    }
}
