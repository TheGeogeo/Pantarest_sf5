<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    #[ORM\Column(type: 'datetime_immutable', options: ["default" => "CURRENT_TIMESTAMP"])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', options: ["default" => "CURRENT_TIMESTAMP"])]
    private $updatedAt;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps()
    {
        $date = new DateTimeImmutable();
        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt($date);
        }
        $this->setUpdatedAt($date);
    }
}
