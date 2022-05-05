<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\PinRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PinRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: 'pin_image', fileNameProperty: 'imageName')]
    private $imageName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

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
