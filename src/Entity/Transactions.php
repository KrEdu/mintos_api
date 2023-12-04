<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?account $account_from = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?account $account_to = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 17, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(length: 3)]
    private ?string $currency = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 10)]
    private ?string $status = 'pending';
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountFrom(): ?account
    {
        return $this->account_from;
    }

    public function setAccountFrom(?account $account_from): static
    {
        $this->account_from = $account_from;

        return $this;
    }

    public function getAccountTo(): ?account
    {
        return $this->account_to;
    }

    public function setAccountTo(?account $account_to): static
    {
        $this->account_to = $account_to;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?String
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
