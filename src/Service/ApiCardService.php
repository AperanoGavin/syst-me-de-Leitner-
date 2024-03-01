<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiCardService{

    private string $uri ;
    public function __construct( private HttpClientInterface $client, string $uri) {
          $this->client = $client;
          $this->uri = $uri;
     }

     public function getAllCard(){
        $response = $this->client->request(
            'GET',
            $this->uri
        );
        
        $content = $response->getContent();
        $content = json_decode($content , true);
       
        return $content; 

    }
}