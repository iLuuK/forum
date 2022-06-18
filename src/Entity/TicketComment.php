<?php

namespace App\Entity;

use App\Repository\TicketCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\UpdatedAtTrait;
use App\Entity\Trait\CreatedAtTrait;

#[ORM\Entity(repositoryClass: TicketCommentRepository::class)]
class TicketComment
{
    use UpdatedAtTrait;
    use CreatedAtTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ticketComments')]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: 'ticketComments')]
    private $ticket;

    public function __construct()
    {
        $this->setUpdatedAt();
        $this->setCreatedAt();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
