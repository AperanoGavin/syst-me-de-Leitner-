<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

Class ApiSheetService{
    private string $uri ;
    public function __construct( private HttpClientInterface $client, string $uri) {
          $this->client = $client;
          $this->uri = $uri;
     }

     public function getAllSheet(){
        $response = $this->client->request(
            'GET',
            $this->uri
        );
        
        $content = $response->getContent();
        $content = json_decode($content , true);

        if(empty($content['hydra:member'])){
            return [];
        }
       
        return $content['hydra:member']; 
    }
}