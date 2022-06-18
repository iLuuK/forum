<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

Trait UpdatedAtTrait
{
    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $updated_at;

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(): self
    {
        $this->updated_at = new \DateTimeImmutable();

        return $this;
    }

}