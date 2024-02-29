<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiSheetService;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
       //si il n'y a pas de token jwt dans la session alors on redirige vers la page de login

        if(!$request->getSession()->get('token')){
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/sheet' , name: 'app_sheet')]
    public function allSheet(Request $request): Response
    {
        $api_sheet = new ApiSheetService();
        $first = $api_sheet->getFisrtSheet();


        return $this->render('home/sheet.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
