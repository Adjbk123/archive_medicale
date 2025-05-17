<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, DossierMedical>
     */
    #[ORM\OneToMany(targetEntity: DossierMedical::class, mappedBy: 'patient')]
    private Collection $dossierMedicals;

    public function __construct()
    {
        $this->dossierMedicals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function __toString(): string
    {
       return  $this->getUser()->getNom(). ' '.$this->getUser()->getPrenoms();
    }

    /**
     * @return Collection<int, DossierMedical>
     */
    public function getDossierMedicals(): Collection
    {
        return $this->dossierMedicals;
    }

    public function addDossierMedical(DossierMedical $dossierMedical): static
    {
        if (!$this->dossierMedicals->contains($dossierMedical)) {
            $this->dossierMedicals->add($dossierMedical);
            $dossierMedical->setPatient($this);
        }

        return $this;
    }

    public function removeDossierMedical(DossierMedical $dossierMedical): static
    {
        if ($this->dossierMedicals->removeElement($dossierMedical)) {
            // set the owning side to null (unless already changed)
            if ($dossierMedical->getPatient() === $this) {
                $dossierMedical->setPatient(null);
            }
        }

        return $this;
    }
}
