<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VendeursRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;




/**
 * @ApiResource(normalizationContext={"groups"={"vendeur:read"}})
 * @ORM\Entity(repositoryClass=VendeursRepository::class)
 */
class Vendeurs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     * @Groups({"vendeur:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read"})
     * @Groups({"vendeur:read"})
     */
    private $AdresseVendeur;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"user:read"})
     * @Groups({"vendeur:read"})
     * 
     * 
     */
    private $TelVendeur;

    /**
     * @ORM\OneToMany(targetEntity=Produits::class, mappedBy="vendeur")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="vendeur")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"vendeur:read"})
     *
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CNI;


    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseVendeur(): ?string
    {
        return $this->AdresseVendeur;
    }

    public function setAdresseVendeur(string $AdresseVendeur): self
    {
        $this->AdresseVendeur = $AdresseVendeur;

        return $this;
    }

    public function getTelVendeur(): ?string
    {
        return $this->TelVendeur;
    }

    public function setTelVendeur(string $TelVendeur): self
    {
        $this->TelVendeur = $TelVendeur;

        return $this;
    }

    /**
     * @return Collection|Produits[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setVendeur($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getVendeur() === $this) {
                $produit->setVendeur(null);
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
