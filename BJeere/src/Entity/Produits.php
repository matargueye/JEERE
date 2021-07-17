<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
 */
class Produits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"produitcomm:read"})
     *
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"produitcomm:read"}) 
     * 
     */
    private $designation;

    /**
     * @ORM\Column(type="float")
     * @Groups({"produitcomm:read"})
     *
     */
    private $prixunitaire;

    /**
     * @ORM\Column(type="float")
     * 
     */

    private $quantitestock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $caracteristique;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Groups({"produitcomm:read"}) 
     */
    private $date_ajout;

    /**
     * @ORM\ManyToOne(targetEntity=Vendeurs::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $vendeur;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieProdui::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"produitcomm:read"}) 
     * 
     * 
     */
    private $categorie;


    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $isActive;

   
    /**
     * @ORM\Column(type="blob")
     * 
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"produitcomm:read"})
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Soucategorie::class, inversedBy="produits")

     *  @ORM\JoinColumn(nullable=true)
     */
    private $soucategorie;

    /**
     * @ORM\OneToMany(targetEntity=CommandesProduits::class, mappedBy="produit", orphanRemoval=true)
     */
    private $commandesProduits;

  


    public function __construct()
    {
        
        
        $this->commandesProduits = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrixunitaire(): ?string
    {
        return $this->prixunitaire;
    }

    public function setPrixunitaire(string $prixunitaire): self
    {
        $this->prixunitaire = $prixunitaire;

        return $this;
    }

    public function getQuantitestock(): ?string
    {
        return $this->quantitestock;
    }

    public function setQuantitestock(string $quantitestock): self
    {
        $this->quantitestock = $quantitestock;
        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(string $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    
    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getVendeur(): ?Vendeurs
    {
        return $this->vendeur;
    }

    public function setVendeur(?Vendeurs $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getCategorie(): ?CategorieProdui
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieProdui $categorie): self	
    
    {
        $this->categorie = $categorie;

        return $this;
    }

   


    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }


    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getSoucategorie(): ?Soucategorie
    {
        return $this->soucategorie;
    }

    public function setSoucategorie(?Soucategorie $soucategorie): self
    {
        $this->soucategorie = $soucategorie;

        return $this;
    }

    /**
     * @return Collection|CommandesProduits[]
     */
    public function getCommandesProduits(): Collection
    {
        return $this->commandesProduits;
    }

    public function addCommandesProduit(CommandesProduits $commandesProduit): self
    {
        if (!$this->commandesProduits->contains($commandesProduit)) {
            $this->commandesProduits[] = $commandesProduit;
            $commandesProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCommandesProduit(CommandesProduits $commandesProduit): self
    {
        if ($this->commandesProduits->removeElement($commandesProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandesProduit->getProduit() === $this) {
                $commandesProduit->setProduit(null);
            }
        }

        return $this;
    }

   

   
}
