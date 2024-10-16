<?php

namespace App\Entity;

use App\Repository\StyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Contraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: StyleRepository::class)]
#[UniqueEntity(
    fields:["nom"],
    message:"Le nom du style est déjà utilisé dans la base."
)]
#[UniqueEntity(
    fields:["couleur"],
    message:"Cette couleur est déjà associé à un style."
)]
class Style
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

       #[Assert\Lenght(
        min:3,
        max:255,
        minMessage:"Le style doit comporter au minimum{{limit}}", 
        maxMessage:"Le style doit comporter au maximum{{limit}}",
        )
    ]

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]

    private ?string $couleur = null;

    #[ORM\ManyToMany(targetEntity: Album::class, inversedBy: 'styles')]
    private Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        $this->albums->removeElement($album);

        return $this;
    }
}
