<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Task;
use App\Entity\User;

class TaskController extends AbstractController
{

    public function index(ManagerRegistry $doctrine): Response
    {
        $eM = $doctrine->getRepository(Task::class);
        $tasks = $eM->findAll();
        $eM = $doctrine->getRepository(User::class);
        $users = $eM->findAll();

        foreach ($tasks as $task) {
            echo $task->getUser()->getEmail() . '-' . $task->getTitle() . '<br>';
        }
        
        echo "-----------------<br>";

        foreach ($users as $user){
            echo $user->getEmail()."<br>";
            $tasks = $user->getTasks();

            foreach ($tasks as $task){
                echo "---->". $task->getTitle()."<br>";
            }
        };

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
