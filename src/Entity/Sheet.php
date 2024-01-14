<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SheetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: SheetRepository::class)]
#[ApiResource]
#[Broadcast]
class Sheet 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $result = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_good = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): static
    {
        $this->result = $result;

        return $this;
    }

    public function isIsGood(): ?bool
    {
        return $this->is_good;
    }

    public function setIsGood(?bool $is_good): static
    {
        $this->is_good = $is_good;

        return $this;
    }
}
