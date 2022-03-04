<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Form\RegisterType;
use App\Entity\User;

class UserController extends AbstractController
{
    
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine)
    {
        $user = new User();
        $form=$this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new \DateTime('now'));
            
            $user->setPassword(
                $passwordHasher->hashPassword( 
                    $user, 
                    $user->getPassword()
                )
            );
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'lastUsername' => $lastUsername, 
            'error' => $error
        ]);
    }


    public function logout() : void
    {
        throw new \Exception('This should never be reached!');
    }

    
}
