<?php
namespace App\Tests\Service;

use App\Controller\CardController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CardControllerTest extends  WebTestCase
{
    //test unitaire pour voir si la méthode getCard() du controller CardController retourne bien un tableau
    public function testGetCardCollectionExpected200()
    {
        $client = static::createClient();

        $client->request('GET', 'http://localhost:8000/cards');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetCardCollectionExpected404()
    {
        $client = static::createClient();

        $client->request('GET', 'http://localhost:8000/card');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }


    public function testGetCard()
    {
        $client = static::createClient();

        $client->request('GET', 'http://localhost:8000/cards/quizz', ['date' => '2023-01-01']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));

        $responseContent = json_decode($client->getResponse()->getContent(), true);
        foreach ($responseContent as $card) {
            $this->assertArrayHasKey('id', $card);
            $this->assertArrayHasKey('question', $card);
            $this->assertArrayHasKey('answer', $card);
            $this->assertArrayHasKey('tag', $card);
        }
    }


    public function testGetAllCardsWithoutTags()
    {
        $client = static::createClient();
        $client->request('GET', 'http://localhost:8000/cards');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testGetAllCardsWithTags()
    {
        $client = static::createClient();
        $client->request('GET', 'http://localhost:8000/cards?tag=test');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseContent = json_decode($client->getResponse()->getContent(), true);

        foreach ($responseContent as $card) {
            $this->assertArrayHasKey('category', $card);
            $this->assertArrayHasKey('question', $card);
            $this->assertArrayHasKey('answer', $card);
            $this->assertArrayHasKey('tag', $card);
        }

    }

    public function testPostCards()
    {
        $client = static::createClient();
        $client->request('POST', 'http://localhost:8000/cards', [], [], ['CONTENT_TYPE' => 'application/json'], '{"question":"test","answer":"test","tag":"test"}');

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }



}



