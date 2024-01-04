<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ApiUserService;
use App\Entity\User;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class SecurityController extends AbstractController
{
    private $em;

    private $ApiUserService ;

    public function __construct(EntityManagerInterface $em , ApiUserService $ApiUserService ){
        $this->em =$em ;
        $this->ApiUserService = $ApiUserService;
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils , Request $request ): Response
    {
        //$this->generateUrl('my_route',  array('type' => 'param'), true);
        // $userAll = $this->apiUser ; 
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        $user = new User;
        $form = $this->createForm(LoginType::class , $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            try{
                $email = $request->request->all()['login']['email'];
                $password = $request->request->all()['login']['password'];
                $token = $request->request->all()['login']['_token'];
                $users = $this->ApiUserService->getUser($email);
            }catch(\Exception $e){
                $this->addFlash('message', 'User not found');
                return $this->redirectToRoute('app_login');
            }

        $session = $request->getSession();
        $session->set('token', $token);
        //dd($session);

        //dd($users);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', 
        ['last_username' => $lastUsername, 'error' => $error,
                      'form' =>$form->createView()
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): RedirectResponse
    {
        $session->clear();
        return new RedirectResponse("https://localhost:8000/");
       // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
