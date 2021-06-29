<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

Class AwxGenerator
{
    public function getAwxJobs($token): array
    {
        $client = HttpClient::createForBaseUri('http://127.0.0.1/', [
            'auth_bearer' => $token,
        ]); 

        $response = $client->request('GET', 'http://127.0.0.1/api/v2/jobs/', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        # $content = $response->getContent();
        # $content = $response->toArray();
        # return $content;

        return $response->toArray();
    }
}

