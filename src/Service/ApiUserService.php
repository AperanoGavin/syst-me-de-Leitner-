<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;


Class ApiUserService{

    private $uri = 'http://localhost:8000/api/users';
   public function __construct( private HttpClientInterface $client,) {
         $this->client = $client;
         $this->uri = $uri;
    }

    public function getUser($email){
        $response = $this->client->request(
            'GET',
            $this->uri.$email
        );
        $content = $response->toArray();
        return $content;
}
}