<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "show"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({ "show"})
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "show"})
     */
    private $commiSystem;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "show"})
     */
    private $commiEtat;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "show"})
     */
    private $commiEvoie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     * @Groups({ "show"})
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientEnvoie", inversedBy="transactions")
     * @Groups({ "show"})
     */
    private $clientEnvoie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientRetrait", inversedBy="transactions")
     * @Groups({ "show"})
     */
    private $clientRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "show"})
     */
    private $commitRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "show"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Groups({ "show"})
     */
    private $frais;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Groups({ "show"})
     */
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCommiSystem(): ?int
    {
        return $this->commiSystem;
    }

    public function setCommiSystem(int $commiSystem): self
    {
        $this->commiSystem = $commiSystem;

        return $this;
    }

    public function getCommiEtat(): ?int
    {
        return $this->commiEtat;
    }

    public function setCommiEtat(int $commiEtat): self
    {
        $this->commiEtat = $commiEtat;

        return $this;
    }

    public function getCommiEvoie(): ?int
    {
        return $this->commiEvoie;
    }

    public function setCommiEvoie(int $commiEvoie): self
    {
        $this->commiEvoie = $commiEvoie;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getClientEnvoie(): ?ClientEnvoie
    {
        return $this->clientEnvoie;
    }

    public function setClientEnvoie(?ClientEnvoie $clientEnvoie): self
    {
        $this->clientEnvoie = $clientEnvoie;

        return $this;
    }

    public function getClientRetrait(): ?ClientRetrait
    {
        return $this->clientRetrait;
    }

    public function setClientRetrait(?ClientRetrait $clientRetrait): self
    {
        $this->clientRetrait = $clientRetrait;

        return $this;
    }

    public function getCommitRetrait(): ?int
    {
        return $this->commitRetrait;
    }

    public function setCommitRetrait(int $commitRetrait): self
    {
        $this->commitRetrait = $commitRetrait;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
