<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $pDate = null;

    #[ORM\OneToMany(mappedBy: 'news', targetEntity: Comments::class)]
    private Collection $Comment;

    #[ORM\OneToMany(mappedBy: 'news', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $Comments;

    public function __construct()
    {
        $this->Comment = new ArrayCollection();
        $this->Comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPDate(): ?\DateTimeInterface
    {
        return $this->pDate;
    }

    public function setPDate(\DateTimeInterface $pDate): static
    {
        $this->pDate = $pDate;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->Comment->contains($comment)) {
            $this->Comment->add($comment);
            $comment->setNews($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->Comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getNews() === $this) {
                $comment->setNews(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->Comments;
    }
}
