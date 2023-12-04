<?php
namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/clients')]
class ClientController extends AbstractController
{

    public function __construct(
        private ClientRepository $clientRepository
    )
    {
    }

    #[Route('/')]
    public function getClients()
    {
        $clients = $this->clientRepository->findAll();
        if (!$clients) {
            return new JsonResponse([
                'error' => 'Clients not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $clientsFormatted = [];
        foreach ($clients as $client) {
            $clientsFormatted[] = [
                'id' => $client->getId(),
                'name' => $client->getName(),
                'surname' => $client->getSurname(),
            ];
        }
        return new JsonResponse([
            'clients' => $clientsFormatted
        ], Response::HTTP_OK);
    }

    #[Route('/{id}')]
    public function getClientById($id)
    {
        $client = $this->clientRepository->find($id);
        if (!$client) {
            return new JsonResponse([
                'error' => 'Client not found'
            ], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(
            [
                'id' => $client->getId(),
                'name' => $client->getName(),
                'surname' => $client->getSurname(),
            ],
            Response::HTTP_OK);
    }

    #[Route('/{id}/accounts')]
    public function getAccounts($id)
    {
        $client = $this->clientRepository->find($id);
        if (!$client) {
            return new JsonResponse([
                'error' => 'Client not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $accounts = $client->getAccounts();
        $accountsFormatted = [];
        foreach ($accounts as $account) {
            $accountsFormatted[] = [
                'id' => $account->getId(),
                'name' => $account->getName(),
                'balance' => $account->getBalance(),
                'currency' => $account->getCurrency()
            ];
        }
        return new JsonResponse(
            [
                'accounts' => $accountsFormatted
            ], Response::HTTP_OK);
    }
}