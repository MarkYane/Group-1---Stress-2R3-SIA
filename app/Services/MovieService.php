<?php

namespace App\Services;

use GuzzleHttp\Client;

class MovieService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OMDB_API_KEY');
    }

    public function search($title)
    {
        $response = $this->client->get("http://www.omdbapi.com/?apikey={$this->apiKey}&t={$title}");
        return json_decode($response->getBody(), true);
    }
}
