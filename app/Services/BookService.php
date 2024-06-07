<?php

namespace App\Services;

use GuzzleHttp\Client;

class BookService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function search($title)
    {
        $response = $this->client->get("http://openlibrary.org/search.json?title={$title}");
        return json_decode($response->getBody(), true);
    }
}
