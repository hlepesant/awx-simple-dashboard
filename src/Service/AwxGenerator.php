<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

Class AwxGenerator
{
    private $awx_url;
    private $awx_api;
    private $token;

    public function __construct(string $awx_url, string $awx_api, string $token)
    {
	      $this->awx_url = $awx_url;
	      $this->awx_api = $awx_api;
        $this->token = $token;
    }

    public function getAwxJobs(string $sorted_by, int $page_size, int $page): array
    {
        $client = HttpClient::createForBaseUri($this->awx_api, [
            'auth_bearer' => $this->token,
        ]); 

        $response = $client->request('GET', $this->awx_api.'/api/v2/jobs/', [
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

