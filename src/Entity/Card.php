<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CategoryInterface;

#[ORM\Entity(repositoryClass: CardRepository::class)]
#[ApiResource]
#[ApiResource(
    normalizationContext: ["exclude" => ["category"]],
    denormalizationContext: ["exclude" => ["category"]]
)]


class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]


    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $category;

    #[ORM\Column(length: 255)]
    private string $question;

    #[ORM\Column(length: 255)]
    private string $answer;

    #[ORM\Column(length: 255)]
    private string $tag;

    public function __construct()
    {
        $this->category = CategoryInterface::CATEGORY_FIRST; // Initialisation par défaut de la catégorie
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
