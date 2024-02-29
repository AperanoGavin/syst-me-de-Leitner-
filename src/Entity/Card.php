<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CategoryInterface;


#[ORM\Entity(repositoryClass: CardRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
    ])
]

class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private string $category;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private string $question;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private string $answer;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private string $tag;

    public function __construct()
    {
        $this->category = CategoryInterface::CATEGORY_FIRST; // Initialisation par défaut de la catégorie
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['read'])]
    public function getCategory(): string
    {
        return $this->category;
    }

    #[Groups(['write'])]
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    #[Groups(['read'])]
    public function getQuestion(): string
    {
        return $this->question;
    }

    #[Groups(['write'])]
    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    #[Groups(['read'])]
    public function getAnswer(): string
    {
        return $this->answer;
    }

    #[Groups(['write'])]
    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    #[Groups(['read'])]
    public function getTag(): string
    {
        return $this->tag;
    }

    #[Groups(['write'])]
    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}