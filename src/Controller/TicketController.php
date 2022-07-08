<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Category;
use App\Entity\User;
use App\Controller\Trait\RoleTrait;
use App\Controller\Trait\DeleteTrait;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\TicketFormType;
use App\Form\TicketCommentFormType;
use App\Entity\TicketComment;

#[Route('/ticket', name: 'ticket-')]
class TicketController extends AbstractController
{
    use RoleTrait;
    use DeleteTrait;

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
            return $this->redirectToRoute('ticket-detail', ['slug' => $ticket->getSlug()]);
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
    public function detail(Request $request,EntityManagerInterface $entityManager, Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }
        
        /** @var User $user */
        $user = $this->getUser();
    
        $ticketComment = new TicketComment();
        $form = $this->createForm(TicketCommentFormType::class, $ticketComment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $ticketComment->setAuthor($user);
            $ticketComment->setPublishedDate(new \DateTimeImmutable());
            $ticketComment->setTicket($ticket);
            $entityManager->persist($ticketComment);
            $entityManager->flush();
            return $this->redirectToRoute('ticket-detail', ['slug' => $ticket->getSlug()]);
        }

        $ticketCommentsWithoutDelete = $ticket->getNoDeleteTicketComments();
        $reactionsWithoutDelete = $ticket->getNoDeletetReactions();

        $reactions = $ticket->getReactions();
        $userHasLike = false;
        $userHasDislike = false;
        $numberLike = 0;
        $numberDislike = 0;
        foreach ($reactions as &$reaction) {
            if($reaction->getUser()->getId() == $user->getId()){
                if($reaction->getIsLike()){
                    $userHasLike = true;
                }else{
                    $userHasDislike = true;
                }
            }
            if($reaction->getIsLike()){
                $numberLike++;
            }else{
                $numberDislike++;
            }
        }

        return $this->render('ticket/detail.html.twig', [
            'ticket' => $ticket,
            'ticketCommentsWithoutDelete' => $ticketCommentsWithoutDelete,
            'user' => $user,
            'reactions' => $reactionsWithoutDelete,
            'userHasLike' => $userHasLike,
            'userHasDislike' => $userHasDislike,
            'numberLike' => $numberLike,
            'numberDislike' => $numberDislike,
            'ticketCommentForm' => $form->createView()
        ]);
    }

    #[Route('/{slug}/delete', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_ADMINISTRATOR')) {
            return $response;
        }

        $this->deleteTicket($entityManager, $ticket);
        $this->addFlash('success', 'Ticket supprimé !');

        return $this->redirectToRoute('ticket-main');
    }

    #[Route('/{slug}/close', name: 'close')]
    public function close(EntityManagerInterface $entityManager, Ticket $ticket): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $response;
        }

        /** @var User $user */
        $user = $this->getUser();
        if($user->getId() != $ticket->getAuthor()->getId()){
            if($response = $this->checkRole('ROLE_ADMINISTRATOR')){
                return $this->redirectToRoute('ticket-detail', ['slug' => $ticket->getSlug()]);
            }
        }
        $ticket->setIsClose(true);
        $ticket->setUpdatedAt();

        $entityManager->persist($ticket);
        $entityManager->flush();

        return $this->redirectToRoute('ticket-detail', ['slug' => $ticket->getSlug()]);
    }

}
