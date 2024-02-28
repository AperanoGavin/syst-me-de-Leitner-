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
       // $session = $request->getSession;
        dd($request);
        if(!empty($session->get('token'))){
            return $this->redirect('https://localhost:8000/');
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
        dd($first);

        dd($request);

        return $this->render('home/sheet.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
