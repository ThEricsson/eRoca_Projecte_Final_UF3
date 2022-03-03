<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


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
            $entityManager->flush(); //Fer validació de dades
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
}
