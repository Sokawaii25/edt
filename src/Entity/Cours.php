<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as Validators;
#[ORM\Entity(repositoryClass: CoursRepository::class)]
#[Validators\SalleDisponibleChecker()]
#[Validators\ProfesseurDisponibleChecker()]
class Cours implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Assert\GreaterThan('now', message: 'Impossible de créer un cours dans le passé!')]
    #[Assert\Expression(
        "value.format('Hi') >= 800",
        message: 'L`\'heure de début ne peut pas être antérieure à 8h!'
    )]// min 8h pour l'heure de début
    #[Assert\LessThan(propertyPath: 'dateHeureFin', message: 'La date de début doit être antérieure à la date de fin !')] // Date de début < date de fin
    private $dateHeureDebut;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(propertyPath: 'dateHeureDebut', message: 'La date de fin doit être ultérieure à la date de début !')] // Date de fin > date de début
    #[Assert\Expression(
        "this.getDateHeureDebut().format('dMy') === value.format('dMy')",
        message: 'La date de début et de fin doivent être dans la même journée!'
    )]// check que la date de fin soit dans la même journée que la date de début
    #[Assert\Expression(
        "value.format('Hi') <= 1900",
        message: 'L\'heure de fin ne peut pas être ultérieure à 19h!'
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

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Avis::class)]
    private $avis;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%s %s (%s - %s)', $this->type, $this->matiere, $this->dateHeureDebut->format('Y-m-d H:i:s'), $this->dateHeureFin->format('Y-m-d H:i:s'));
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
                'id' => $this->professeur->getId(),
                'nom' => $this->professeur->getNom(),
                'prenom' => $this->professeur->getPrenom()
            ],
            'matiere' => $this->matiere,
            'salle' => $this->salle
        ];
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setCours($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getCours() === $this) {
                $avi->setCours(null);
            }
        }

        return $this;
    }

}
