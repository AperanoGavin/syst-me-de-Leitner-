<?php

namespace App\Service;
use Doctrine\ORM\Query\Expr\Base;
use Symfony\Contracts\HttpClient\HttpClientInterface;
//rajoute le use pour l'exception
use Symfony\Component\HttpClient\Exception\ClientException;

Class ApiUserService {

   private string $uri ;
   public function __construct( private HttpClientInterface $client, string $uri) {
         $this->client = $client;
         $this->uri = $uri;
    }

    public function getUser(String $email){
        $response = $this->client->request(
            'GET',
            $this->uri.'email='.$email
        );
        
        $content = $response->getContent();
        $content = json_decode($content , true);
        // $content = $content->toArray();
        //dd($content['hydra:member']);
        if(empty($content['hydra:member'])){
            throw new \Exception('User not found');
        }
       
        return $content['hydra:member']; 
    }


   /*  public function getToken(String $email , String $password)
    {
        $response = $this->client->request(
            'POST',
            "https://localhost:8000/api/login_check",
    ['json' => [
                'email' => $email,
                'password' => $password,
            ]]

        );
        $content = $response->getContent();
        $content = json_decode($content , true);
        dd($content['hydra:member']);
    } */
}