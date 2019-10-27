<?php

namespace App\Entity;

use App\Entity\Depot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Vous devez insérer un bon nom d'utilisateur")
     * @Groups({"show"})
     */
    private $username;
    /**
     * @ORM\Column(type="json")
     * @Groups({"show"})
     */
    private $roles = [];
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min="5", minMessage="Ce champ doit contenir un minimum de 6 caractères")
     * @Assert\NotBlank(message="Vous devez insérer un mot de passe")
     * @Groups({"show"})
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="2",minMessage="Ce champ doit contenir un minimum de 2 lettres")
     * @Assert\NotBlank(message="Vous devez insérer un mot de passe")
     * @Groups({"show"})
     */
    private $nom;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\Length(min="2",minMessage="Ce champ doit contenir un minimum de 2 lettres")
     * @Assert\NotBlank(message="Vous devez insérer un mot de passe")
     * @Groups({"show"})
     */
    private $prenom;
    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="7",minMessage="Ce champ doit contenir un minimum de 7 chiffres")
     * @Assert\NotBlank(message="ce champs ne doit pas etre vide")
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero ne doit pas contenir de lettre"
     * )
     * @Groups({"show"})
     */
    private $tel;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champs ne doit pas etre vide")
     * @Groups({"show"})
     */
    private $mail;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champs ne doit pas etre vide")
     * @Groups({"show"})
     */
    private $adresse;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $statut;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champs ne doit pas etre vide")
     * @Groups({"show"})
     */
    private $ninea;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champs ne doit pas etre vide")
     * @Groups({"show"})
     */
    private $profil;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="user")
     * @Assert\NotBlank(message="ce champs ne doit pas etre vide")
     * @Groups({"show"})
     */
    private $depots;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="images", fileNameProperty="imageName")
     * @Groups({"show"})
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"show"})
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime|null
     * @Groups({"show"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="user")
     * @Groups({"show"})
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
     * @Groups({"show"})
     */
    private $partenaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="user")
     * @Groups({"show"})
     */
    private $compte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $situationMatri;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }
    public function getTel(): ?int
    {
        return $this->tel;
    }
    public function setTel(int $tel): self
    {
        $this->tel = $tel;
        return $this;
    }
    public function getMail(): ?string
    {
        return $this->mail;
    }
    public function setMail(string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
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
    public function getNinea(): ?string
    {
        return $this->ninea;
    }
    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;
        return $this;
    }
    public function getProfil(): ?string
    {
        return $this->profil;
    }
    public function setProfil(string $profil): self
    {
        $this->profil = $profil;
        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }
    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setUser($this);
        }
        return $this;
    }
    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getUser() === $this) {
                $depot->setUser(null);
            }
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
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
            $transaction->setUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getUser() === $this) {
                $transaction->setUser(null);
            }
        }

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

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

    public function getSituationMatri(): ?string
    {
        return $this->situationMatri;
    }

    public function setSituationMatri(string $situationMatri): self
    {
        $this->situationMatri = $situationMatri;

        return $this;
    }

}
