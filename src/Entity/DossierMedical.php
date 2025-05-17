<?php

namespace App\Entity;

use App\Repository\DossierMedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DossierMedicalRepository::class)]
class DossierMedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true)]
    private ?\DateTimeInterface $derniereMiseAJour = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'dossier')]
    private Collection $documents;

    #[ORM\ManyToOne(inversedBy: 'dossierMedicals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDerniereMiseAJour(): ?\DateTimeInterface
    {
        return $this->derniereMiseAJour;
    }

    public function setDerniereMiseAJour(\DateTimeInterface $derniereMiseAJour): static
    {
        $this->derniereMiseAJour = $derniereMiseAJour;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setDossier($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getDossier() === $this) {
                $document->setDossier(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return 'DOSSIER DU PATIENT ' . $this->getPatient()->getUser()->getPrenoms() . ' ' . $this->getPatient()->getUser()->getNom() . ' - Date de création : ' . ($this->getDateCreation() ? $this->getDateCreation()->format('Y-m-d H:i:s') : 'Non spécifiée');
    }


    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }
}
