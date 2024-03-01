<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Card;


class CardController extends AbstractController
{

    #[Route('/cards/quizz', name: 'app_card')]
    public function getCard(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $date = $request->query->get('date');
        $cardRepository = $managerRegistry->getRepository(Card::class);
        $cards = $cardRepository->findCardByDateOrToday($date);
        $cards = array_map(function($card){
            return [
                'id' => $card->getId(),
                'question' => $card->getQuestion(),
                'answer' => $card->getAnswer(),
                'tag' => $card->getTag()            ];
        }, $cards);

        return $this->json($cards);
    }


    #[Route('/cards/{cardId}/answer', name: 'answer_card', methods: ['PATCH'])]
    public function answerCard(Request $request , ManagerRegistry $managerRegistry, $cardId): Response
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $managerRegistry->getManager();
        $card = $entityManager->getRepository(Card::class)->find($cardId);

        // verif si la carte existe
        if (!$card) {
            return new Response("Card not found", Response::HTTP_NOT_FOUND);
        }

        // Update la 
        $answeredCorrectly = isset($data['isValid']) ? $data['isValid'] : false;
        
        $card->setIsValid($answeredCorrectly);

        // Save changes to the database
        $entityManager->flush();

        $card = [
            'isValid' => $card->isIsValid()
        ];

        //ne retourner que  is_valid
        return $this->json($card);
        }




}