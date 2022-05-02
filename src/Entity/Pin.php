<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\PinRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PinRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Pin
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Title can't be blank.")]
    #[Assert\Length(min: 3, minMessage: "Title need minimun {{ limit }} caractere.", max: 255, maxMessage: "Title can't have more {{ limit }} caractere.")]
    private $title;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "Description can't be blank.")]
    #[Assert\Length(min: 10, minMessage: "Description need minimun {{ limit }} caractere.")]
    private $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
