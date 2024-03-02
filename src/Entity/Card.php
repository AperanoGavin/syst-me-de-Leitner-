<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use  ApiPlatform\Metadata\ApiProperty;
use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CategoryInterface;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\CardController;



#[ORM\Entity(repositoryClass: CardRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['get']],
    denormalizationContext: ['groups' => ['post']],
)]
#[Get]
#[Post]
#[GetCollection]
#[ApiFilter(SearchFilter::class, properties: ['tag' => 'exact' ,'date'=> 'exact'])]


class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get'])]
    private string $category;

    #[ORM\Column(length: 255)]
    #[Groups(['get', 'post'])]
    private string $question;

    #[ORM\Column(length: 255)]
    #[Groups(['get', 'post'])]
    private string $answer;

    #[ORM\Column(length: 255)]
    #[Groups(['get', 'post'])]
    private string $tag;

    #[ORM\Column(length: 255)]
    private ?string $date ;


    public function __construct()
    {
        $this->category = CategoryInterface::CATEGORY_FIRST; // Initialisation par défaut de la catégorie
        $this->date = date('Y-m-d'); // Initialisation par défaut de la date du jour si non renseignée

    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): static
    {
        $this->date = $date;

        return $this;
    }





}