<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

Class ApiSheetService{
    private string $uri ;
    public function __construct( private HttpClientInterface $client, string $uri) {
          $this->client = $client;
          $this->uri = $uri;
     }

     
}