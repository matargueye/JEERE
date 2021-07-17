<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  @ApiResource(iri="http://schema.org/Commandes",
 * normalizationContext={"groups"={"commande:read"}})
 * @ORM\Entity(repositoryClass=CommandesRepository::class)
 */
class Commandes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"commande:read"})
     * @Groups({"produitcomm:read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"commande:read"})
     * @Groups({"produitcomm:read"})
     */
    private $DateCommande;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"commande:read"})
     * 
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Livreurs::class, inversedBy="commande")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"commande:read"})
     */
    private $livreurs;
   
    /**
     * @ORM\OneToMany(targetEntity=CommandesProduits::class, mappedBy="commande", orphanRemoval=true)
     *  @Groups({"commande:read"})
     */
    private $commandesProduits;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     *  
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numcommande;

    public function __construct()
    {
       
        $this->commandesProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->DateCommande;
    }

    public function setDateCommande(\DateTimeInterface $DateCommande): self
    {
        $this->DateCommande = $DateCommande;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLivreurs(): ?Livreurs
    {
        return $this->livreurs;
    }

    public function setLivreurs(?Livreurs $livreurs): self
    {
        $this->livreurs = $livreurs;

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
            $commandesProduit->setCommande($this);
        }

        return $this;
    }

    public function removeCommandesProduit(CommandesProduits $commandesProduit): self
    {
        if ($this->commandesProduits->removeElement($commandesProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandesProduit->getCommande() === $this) {
                $commandesProduit->setCommande(null);
            }
        }

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNumcommande(): ?string
    {
        return $this->numcommande;
    }

    public function setNumcommande(string $numcommande): self
    {
        $this->numcommande = $numcommande;

        return $this;
    }
}
