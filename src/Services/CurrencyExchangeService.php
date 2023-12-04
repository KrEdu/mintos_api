<?php

namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CurrencyExchangeService
{
    private string $baseUrl = 'https://v6.exchangerate-api.com/v6';
    private string $apiKey;
    public function __construct()
    {
        $this->apiKey = $_ENV['EXCHANGE_CURRENCY_API_KEY'];
    }

    public function exchangeCurrency(string $from, string $to, float $amount): array
    {
        $url = $this->buildUrl($from, $to, $amount);
        $client = HttpClient::create();
        try {
            $response = $client->request(
                'GET',
                $url
            );
        } catch (TransportExceptionInterface $e) {
            return [
                'success' => false,
                'result' => $e->getMessage()
            ];
        }
        if ($response->getStatusCode() !== 200) {
            return [
                'success' => false,
                'result' => 'Exchange service unavailable'
            ];
        }
        $data = $response->toArray();
        return [
            'success' => true,
            'result' =>  $data['conversion_result']
        ];
    }

    private function buildUrl(string $from, string $to, float $amount): string
    {
        $url =
            $this->baseUrl .'/' .
            $this->apiKey . '/' .
            '/pair/' .
            $to . '/' .
            $from . '/' .
            $amount;
        return $url;
    }
}