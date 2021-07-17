<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *@ApiResource(normalizationContext={"groups"={"client:read"}})
 * @ORM\Entity(repositoryClass=ClientsRepository::class)
 */
class Clients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"client:read"})
     * 
     * 
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"client:read"})
     * 
     * 
     *  
     * 
     */
    private $AdresseClient;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"client:read"})
     * 
     * 
     * 
     * 
     */
    private $TelClient;

    

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="client")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"client:read"})
     * 
     * 
     */
    private $users;

    

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseClient(): ?string
    {
        return $this->AdresseClient;
    }

    public function setAdresseClient(string $AdresseClient): self
    {
        $this->AdresseClient = $AdresseClient;

        return $this;
    }

    public function getTelClient(): ?string
    {
        return $this->TelClient;
    }

    public function setTelClient(string $TelClient): self
    {
        $this->TelClient = $TelClient;

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

 
}
