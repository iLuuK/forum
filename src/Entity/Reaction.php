<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Entity\Trait\IsDeletedTrait;

#[ORM\Entity(repositoryClass: ReactionRepository::class)]
class Reaction
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use IsDeletedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: 'reactions')]
    private $ticket;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reactions')]
    private $user;

    #[ORM\Column(type: 'boolean')]
    private $isLike;

    public function __construct()
    {
        $this->setCreatedAt();
        $this->setUpdatedAt();
        $this->setIsDeleted(false);
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsLike(): ?bool
    {
        return $this->isLike;
    }

    public function setIsLike(bool $isLike): self
    {
        $this->isLike = $isLike;

        return $this;
    }
}
