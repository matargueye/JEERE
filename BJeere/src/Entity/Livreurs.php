<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreursRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;


/**
 * @ApiResource(iri="http://schema.org/Produits")
 * @ORM\Entity(repositoryClass=LivreursRepository::class)
 * @Vich\Uploadable
 */
class Livreurs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse_Livreur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tel_Livreur;

    /**
     * @ORM\OneToMany(targetEntity=Commandes::class, mappedBy="livreurs")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="livreur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Villes::class, inversedBy="livreurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CNI;

   
    public function __construct()
    {
        $this->commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getAdresseLivreur(): ?string
    {
        return $this->Adresse_Livreur;
    }

    public function setAdresseLivreur(string $Adresse_Livreur): self
    {
        $this->Adresse_Livreur = $Adresse_Livreur;

        return $this;
    }

    public function getTelLivreur(): ?string
    {
        return $this->Tel_Livreur;
    }

    public function setTelLivreur(string $Tel_Livreur): self
    {
        $this->Tel_Livreur = $Tel_Livreur;

        return $this;
    }

    /**
     * @return Collection|Commandes[]
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
            $commande->setLivreurs($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivreurs() === $this) {
                $commande->setLivreurs(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getVille(): ?Villes
    {
        return $this->ville;
    }

    public function setVille(?Villes $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCNI(): ?string
    {
        return $this->CNI;
    }

    public function setCNI(string $CNI): self
    {
        $this->CNI = $CNI;

        return $this;
    }
   
}
