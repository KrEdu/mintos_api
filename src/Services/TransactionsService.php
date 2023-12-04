<?php

namespace App\Services;

use App\Entity\Account;
use App\Entity\Transactions;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\Clock\now;

class TransactionsService
{
    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';
    const STATUS_FINISHED = 'finished';

    private string $status = self::STATUS_PENDING;
    private string $error;
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function createTransfer(
        Account $from,
        Account $to,
        string $currency,
        float $amount,
    ): void {
        $exchangeService = new CurrencyExchangeService();
        $exchangeResult = $exchangeService->exchangeCurrency(
            $from->getCurrency(),
            $to->getCurrency(),
            $amount
        );
        if (($exchangeResult['success'] && is_numeric($exchangeResult['result'])) || true) {
            $amountFrom = $exchangeResult['result'];
            if ($from->getBalance() < $amountFrom) {
                $this->status = self::STATUS_FAILED;
                $this->error = 'Not enough funds ' . $amount;
                return;
            }
            $this->status = self::STATUS_FINISHED;
            $this->updateAccounts(
                $from,
                $to,
                $amountFrom,
                $amount
            );
        }
        $this->createTransaction(
            $from,
            $to,
            $amount,
            $currency
        );
    }

    private function updateAccounts(
        Account $from,
        Account $to,
        float $amountFrom,
        float $amountTo
    ): void {
        $from->setBalance($from->getBalance() - $amountFrom);
        $to->setBalance($to->getBalance() + $amountTo);
        $this->entityManager->persist($from);
        $this->entityManager->persist($to);
        $this->entityManager->flush();
    }

    private function createTransaction(
        Account $from,
        Account $to,
        float $amount,
        string $currency
    ) {
        $transfer = new Transactions();
        $transfer->setAccountFrom($from);
        $transfer->setAccountTo($to);
        $transfer->setAmount($amount);
        $transfer->setCurrency($currency);
        $transfer->setStatus($this->status);
        $transfer->setDate(now());

        $this->entityManager->persist($transfer);
        $this->entityManager->flush();
    }

    public function getError(): string
    {
        return  $this->error;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}