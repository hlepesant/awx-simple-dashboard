<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

Class AwxGenerator
{
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getAwxJobs(string $sorted_by, int $page_size, int $page): array
    {
        $client = HttpClient::createForBaseUri('http://127.0.0.1/', [
            'auth_bearer' => $this->token,
        ]); 

        $response = $client->request('GET', 'http://127.0.0.1/api/v2/jobs', [
            'query' => [
                'order_by' => sprintf('%s', $sorted_by),
                'page_size' => $page_size,
                'page' => $page,
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();

        if ( $statusCode != 200 ) {
            return array();
        }

        return $response->toArray();
    }
}

