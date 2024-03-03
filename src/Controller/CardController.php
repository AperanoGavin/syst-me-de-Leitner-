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
        $now = new \DateTime();

        $cards = array_filter($cards, function($card) use ($now) {
        $createdAt = new \DateTime($card->getDate());
        $daysSinceCreation = $now->diff($createdAt)->days;

        switch ($card->getCategory()) {
            case CategoryEnum::FIRST->value:
                return $daysSinceCreation % 1 == 0;
            case CategoryEnum::SECOND->value:
                return $daysSinceCreation % 2 == 0;
            case CategoryEnum::THIRD->value:
                return $daysSinceCreation % 4 == 0;
            case CategoryEnum::FOURTH->value:
                return $daysSinceCreation % 8 == 0;
            case CategoryEnum::FIFTH->value:
                return $daysSinceCreation % 16 == 0;
            case CategoryEnum::SIXTH->value:
                return $daysSinceCreation % 32 == 0;
            case CategoryEnum::SEVENTH->value:
                return $daysSinceCreation % 64 == 0;
            default:
                return $card->getCategory() !== CategoryEnum::DONE->value;
        }
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
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P2D'));
                        $card->setDate($nextDate->format('Y-m-d'));

                    break;
                case CategoryEnum::SECOND:
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P4D'));
                        $card->setDate($nextDate->format('Y-m-d'));

                    break;
                case CategoryEnum::THIRD:
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P8D'));
                        $card->setDate($nextDate->format('Y-m-d'));

                    break;
                case CategoryEnum::FOURTH:
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P16D'));
                        $card->setDate($nextDate->format('Y-m-d'));

                    break;
                case CategoryEnum::FIFTH:
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P32D'));
                        $card->setDate($nextDate->format('Y-m-d'));
                        
                    break;
                case CategoryEnum::SIXTH:
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);
                        $nextDate = clone $now;
                        $nextDate->add(new \DateInterval('P64D'));
                        $card->setDate($nextDate->format('Y-m-d'));

                    break;
                case CategoryEnum::SEVENTH:
                        $nextCategory = $categoryEnum->getNext();
                        $card->setCategory($nextCategory->value);

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