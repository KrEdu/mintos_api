<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Account::class)]
    private Collection $accounts;


    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccounts(Account $ye): static
    {
        if (!$this->accounts->contains($ye)) {
            $this->accounts->add($ye);
            $ye->setClientId($this);
        }

        return $this;
    }

    public function removeAccounts(Account $ye): static
    {
        if ($this->accounts->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getClientId() === $this) {
                $ye->setClientId(null);
            }
        }

        return $this;
    }
}
