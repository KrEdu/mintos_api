<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\TransactionsRepository;
use App\Requests\GetTransactionsRequest;
use App\Requests\TransferFundsRequest;
use App\Services\TransactionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/accounts')]
class AccountController extends AbstractController
{
    public function __construct(
        private AccountRepository $accountRepository
    )
    {
    }

    #[Route('/{id}', methods: "GET")]
    public function getAccountById(int $id)
    {
        $account = $this->accountRepository->find($id);
        if (!$account) {
            return $this->getNoAccountFoundError();
        }
        return new JsonResponse(
            [
                'id' => $account->getId(),
                'name' => $account->getName(),
                'balance' => $account->getBalance(),
                'currency' => $account->getCurrency()
            ],
            Response::HTTP_OK);
    }

    #[Route('/{id}/transactions', methods: "GET")]
    public function getAccountTransactions(
        TransactionsRepository $transactionsRepository,
        int $id,
        GetTransactionsRequest $request
    ) {
        $account = $this->accountRepository->find($id);
        if (!$account) {
            return $this->getNoAccountFoundError();
        }
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $transactions = $transactionsRepository->findByAccountId($id, $offset, $limit);
        $transactionsFormatted = [];
        foreach ($transactions as $transaction) {
            $isDeposit = true;
            if ($account->getId() === $transaction->getAccountFrom()->getId())
            {
                $transferAccount = $transaction->getAccountTo();
                $isDeposit = false;
            } else {
                $transferAccount = $transaction->getAccountFrom();
            }

            $transactionsFormatted[] = [
                'id' => $transaction->getId(),
                'type' => $isDeposit ? 'deposit' : 'withdrawal',
                'status' => $transaction->getStatus(),
                $isDepoasit ? 'account_from' : 'account_to' => $this->getAccountNameAndId($transferAccount),
                'amount' => $transaction->getAmount(),
                'currency' => $transaction->getCurrency()
            ];
        }
        return new JsonResponse(
            [
                'transactions' => $transactionsFormatted
            ], Response::HTTP_OK
        );
    }

    private function getAccountNameAndId(Account $account): array
    {
        return [
            'id' => $account->getId(),
            'name' => $account->getName()
        ];
    }

    #[Route('/{id}/transfer-funds', methods: "POST")]
    public function transferFunds(TransactionsService $transferService, int $id, TransferFundsRequest $request)
    {
        if (!$fromAccount = $this->accountRepository->find($id)) {
            return $this->getNoAccountFoundError();
        }
        $toAccount = $this->accountRepository->find($request->get('account_to'));
        if (!$toAccount) {
            return new JsonResponse(
                ['error' => 'Account To not found'],
                Response::HTTP_BAD_REQUEST
            );
        }
        $currency = $request->get('currency');
        if($toAccount->getCurrency() !== $currency) {
            return new JsonResponse(
                ['error' => 'Currency must match receiver account'],
                Response::HTTP_BAD_REQUEST
            );
        }
        $amount = $request->get('amount');
        $transferService->createTransfer(
            $fromAccount,
            $toAccount,
            $currency,
            $amount
        );
        if ($transferService->getStatus() === TransactionsService::STATUS_FAILED) {
            return new JsonResponse(
                ['error' => $transferService->getError()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        return new JsonResponse(
            [
                'success' => true,
                'status' => $transferService->getStatus()
            ], Response::HTTP_OK
        );

    }

    private function getNoAccountFoundError(): JsonResponse
    {
        return new JsonResponse([
            'error' => 'Account not found'
        ], Response::HTTP_BAD_REQUEST);
    }
}
