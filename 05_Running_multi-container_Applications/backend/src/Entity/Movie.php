<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MovieRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[Assert\NotBlank]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $title;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
