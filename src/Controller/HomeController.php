<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Task;

class HomeController extends AbstractController
{
    
    public function index(ManagerRegistry $doctrine, UserInterface $user): Response
    {
        $eM = $doctrine->getRepository(Task::class);
        $tasks = $eM->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tasks' => $tasks,
            'userData' => $user
        ]);
    }
}
