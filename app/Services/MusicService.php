<?php

namespace App\Services;

use GuzzleHttp\Client;

class MusicService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://itunes.apple.com',
            'verify' => false // Disable SSL verification if necessary
        ]);
    }

    public function search($title)
    {
        $response = $this->client->get("/search", [
            'query' => [
                'term' => $title,
                'entity' => 'album' // Change 'entity' to 'album' or 'musicTrack'
            ]
        ]);
        return json_decode($response->getBody(), true);
    }
}
