<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRetraitRepository")
 */
class ClientRetrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     */
    private $id;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="clientRetrait")
     * @Groups({"show"})
     */
    private $transactions;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $nomE;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $prenomE;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     */
    private $telE;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $nomR;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $prenomR;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     */
    private $telR;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"show"})
     */
    private $cin;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"show"})
     */
    private $dateretrait;


    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setClientRetrait($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getClientRetrait() === $this) {
                $transaction->setClientRetrait(null);
            }
        }

        return $this;
    }

    public function getNomE(): ?string
    {
        return $this->nomE;
    }

    public function setNomE(string $nomE): self
    {
        $this->nomE = $nomE;

        return $this;
    }

    public function getPrenomE(): ?string
    {
        return $this->prenomE;
    }

    public function setPrenomE(string $prenomE): self
    {
        $this->prenomE = $prenomE;

        return $this;
    }

    public function getTelE(): ?int
    {
        return $this->telE;
    }

    public function setTelE(int $telE): self
    {
        $this->telE = $telE;

        return $this;
    }

    public function getNomR(): ?string
    {
        return $this->nomR;
    }

    public function setNomR(string $nomR): self
    {
        $this->nomR = $nomR;

        return $this;
    }

    public function getPrenomR(): ?string
    {
        return $this->prenomR;
    }

    public function setPrenomR(string $prenomR): self
    {
        $this->prenomR = $prenomR;

        return $this;
    }

    public function getTelR(): ?int
    {
        return $this->telR;
    }

    public function setTelR(int $telR): self
    {
        $this->telR = $telR;

        return $this;
    }


    /**
     * Get the value of cin
     */ 
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set the value of cin
     *
     * @return  self
     */ 
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateretrait(): ?\DateTimeInterface
    {
        return $this->dateretrait;
    }

    public function setDateretrait(\DateTimeInterface $dateretrait): self
    {
        $this->dateretrait = $dateretrait;

        return $this;
    }
}
