<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Card;
use App\Entity\CategoryInterface;
use App\Entity\CategoryEnum;


class CardController extends AbstractController
{

    #[Route('/cards/quizz', name: 'app_card')]
    public function getCard(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $date = $request->query->get('date');
        $cardRepository = $managerRegistry->getRepository(Card::class);
        $cards = $cardRepository->findCardByDateOrToday($date);
        $cards = array_filter($cards, function($card){
            return $card->getCategory() !== CategoryEnum::DONE;
        });
        $cards = array_map(function($card){
            return [
                'id' => $card->getId(),
                'category' => $card->getCategory(),
                'question' => $card->getQuestion(),
                'answer' => $card->getAnswer(),
                'tag' => $card->getTag()            
            ];
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
        
        //$card->setIsValid($answeredCorrectly);

        // Save changes to the database
        //$entityManager->flush();


        if($answeredCorrectly === true){
            $category = $card->getCategory();
            $categoryEnum = CategoryEnum::from($category);
            $initdate = new \DateTime($card->getdate());
            $now = new \DateTime();
            $daysSinceLastAnswer = $now->diff($initdate)->days;
    
            switch ($categoryEnum) {
                case CategoryEnum::FIRST:
                    if ($daysSinceLastAnswer % 1 ==0 || $category === CategoryEnum::FIRST->value) {
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P2D'));
                        $card->setDate($nextDate->format('Y-m-d'));

                    }
                    break;
                case CategoryEnum::SECOND:
                    if ($daysSinceLastAnswer % 2 == 0 ) {
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P4D'));
                        $card->setDate($nextDate->format('Y-m-d'));
                        
                    }
                    break;
                case CategoryEnum::THIRD:
                    if ($daysSinceLastAnswer % 4) {
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P8D'));
                        $card->setDate($nextDate->format('Y-m-d'));
                        
                    }
                    break;
                case CategoryEnum::FOURTH:
                    if ($daysSinceLastAnswer % 8) {
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P16D'));
                        $card->setDate($nextDate->format('Y-m-d'));
                    }
                    break;
                case CategoryEnum::FIFTH:
                    if ($daysSinceLastAnswer % 16) {
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P32D'));
                        $card->setDate($nextDate->format('Y-m-d'));
                        
                    }
                    break;
                case CategoryEnum::SIXTH:
                    if ($daysSinceLastAnswer % 32) {
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P64D'));
                        $card->setDate($nextDate->format('Y-m-d'));
                    }
                    break;

                case CategoryEnum::SEVENTH:
                    if ($daysSinceLastAnswer % 64) {
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);

                    }
                    break;
                case CategoryEnum::DONE:
                    //$entityManager->remove($card);
                    break;

            }
    
            $entityManager->flush();
        }else{
            $card->setCategory(CategoryEnum::FIRST->value);
            $entityManager->flush();
        }


        

        return $this->json($card) 
        ->setStatusCode(Response::HTTP_NO_CONTENT);
        }


}