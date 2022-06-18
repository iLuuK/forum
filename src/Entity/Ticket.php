<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    use UpdatedAtTrait;
    use CreatedAtTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\Column(type: 'datetime')]
    private $published_date;

    #[ORM\Column(type: 'boolean')]
    private $is_close;

    #[ORM\Column(type: 'boolean')]
    private $is_delete;

    #[ORM\OneToMany(mappedBy: 'ticket', targetEntity: TicketComment::class)]
    private $ticketComments;

    public function __construct()
    {
        $this->setUpdatedAt();
        $this->setCreatedAt();
        $this->setIsClose(false);
        $this->setIsDelete(false);
        $this->ticketComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->published_date;
    }

    public function setPublishedDate(\DateTimeInterface $published_date): self
    {
        $this->published_date = $published_date;

        return $this;
    }

    public function getIsClose(): ?bool
    {
        return $this->is_close;
    }

    public function setIsClose(bool $is_close): self
    {
        $this->is_close = $is_close;

        return $this;
    }

    public function getIsDelete(): ?bool
    {
        return $this->is_delete;
    }

    public function setIsDelete(bool $is_delete): self
    {
        $this->is_delete = $is_delete;

        return $this;
    }

    /**
     * @return Collection<int, TicketComment>
     */
    public function getTicketComments(): Collection
    {
        return $this->ticketComments;
    }

    public function addTicketComment(TicketComment $ticketComment): self
    {
        if (!$this->ticketComments->contains($ticketComment)) {
            $this->ticketComments[] = $ticketComment;
            $ticketComment->setTicket($this);
        }

        return $this;
    }

    public function removeTicketComment(TicketComment $ticketComment): self
    {
        if ($this->ticketComments->removeElement($ticketComment)) {
            // set the owning side to null (unless already changed)
            if ($ticketComment->getTicket() === $this) {
                $ticketComment->setTicket(null);
            }
        }

        return $this;
    }
}
