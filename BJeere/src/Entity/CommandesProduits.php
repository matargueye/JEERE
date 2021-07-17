<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandesProduitsRepository;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ApiResource( normalizationContext={"groups"={"produitcomm:read"}})
 * @ORM\Entity(repositoryClass=CommandesProduitsRepository::class)
 */
class CommandesProduits
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
     * @ORM\ManyToOne(targetEntity=Commandes::class, inversedBy="commandesProduits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"produitcomm:read"})
     * 
     *  
     *
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Produits::class, inversedBy="commandesProduits")
     * @ORM\JoinColumn(nullable=false)
     * 
     * 
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commandes
    {
        return $this->commande;
    }

    public function setCommande(?Commandes $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produits
    {
        return $this->produit;
    }

    public function setProduit(?Produits $produit): self
    {
        $this->produit = $produit;

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
}
