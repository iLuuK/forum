<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

Trait IsDeletedTrait
{
    #[ORM\Column(type: 'boolean')]
    private $is_deleted;

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

}