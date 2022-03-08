<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Assert\GreaterThan('now')]
    #[Assert\Expression(
        "value.format('Hi') >= 800",
        message: 'L`\'heure de début ne peut pas être inférieure à 8h!'
    )]// min 8h pour l'heure de début
    #[Assert\LessThan(propertyPath: 'dateHeureFin')] // Date de début < date de fin
    private $dateHeureDebut;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(propertyPath: 'dateHeureDebut')] // Date de fin > date de début
    #[Assert\Expression(
        "this.getDateHeureDebut().format('dMy') === value.format('dMy')",
        message: 'La date de début et de fin doivent être dans la même journée!'
    )]// check que la date de fin soit dans la même journée que la date de début
    #[Assert\Expression(
        "value.format('Hi') <= 1900",
        message: 'L\'heure de fin ne peut pas excéder 19h!'
    )]// max 19h pour date de fin
    private $dateHeureFin;

    #[ORM\Column(type: 'string', length: 20)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Matiere::class, inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    private $matiere;

    #[ORM\ManyToOne(targetEntity: Salle::class, inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    private $salle;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    private $professeur;

    public function __toString()
    {
        return sprintf('%s %s (%s - %s)', $this->type, $this->matiere, $this->dateHeureDebut, $this->dateHeureFin);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeInterface
    {
        return $this->dateHeureFin;
    }

    public function setDateHeureFin(\DateTimeInterface $dateHeureFin): self
    {
        $this->dateHeureFin = $dateHeureFin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'dateHeureDebut' => [
                'date' => $this->dateHeureDebut->format('d/m/Y'),
                'heure' => $this->dateHeureDebut->format('H:i'),
            ],
            'dateHeureFin' => [
                'date' => $this->dateHeureFin->format('d/m/Y'),
                'heure' => $this->dateHeureFin->format('H:i'),
            ],
            'type' => $this->type,
            'professeur' => [
                'nom' => $this->professeur->getNom(),
                'prenom' => $this->professeur->getPrenom()
            ],
            'matiere' => $this->matiere,
            'salle' => $this->salle
        ];
    }
}
