<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Form\TaskType;
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

    public function detail(Task $task){
        if (!$task){
            return $this->redirectToRoute('app_TaskList');
        } else {
            return $this->render('task/detail.html.twig', [
                'task' => $task
            ]);
        }
    }

    public function creation(Request $request, UserInterface $user, ManagerRegistry $doctrine){
        $task = new Task;
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', ['id'=> $task->getId()])
            );
        }

        return $this->render('task/creation.html.twig',[
            'edit'=>true,
            'form'=>$form->createView()
        ]);
    }

    public function delete(ManagerRegistry $doctrine, UserInterface $user, Task $task){
        if (!$user || ($user->getId() != $task->getUser()->getId())){
            return $this->redirectToRoute('app_TaskList');
        } else {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_TaskList');
        } 
    }

    public function edit(Request $request, UserInterface $user, Task $task, ManagerRegistry $doctrine){
        #Si les credencials del usuari son diferents a la de la tasca, o be l'usuari no existeix retornara a la llista de tasques
        if (!$user || ($user->getId() != $task->getUser()->getId())){
            return $this->redirectToRoute('app_TaskList');
        } else {
            $form = $this->createForm(TaskType::class, $task);
            $form->handleRequest($request);
            #En cas que el formulari s'hagi enviat i sigui vàlid, s'editarà
            if ($form->isSubmitted() && $form->isValid()){

                $task->setCreatedAt(new \DateTime('now'));
                $task->setUser($user);

                $em= $doctrine->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirect(
                    $this->generateUrl('task_detail', ['id' => $task->getId()])
                );

            }
        }
        #Si no es crearà el formulari
        return $this->render('task/creation.html.twig',[
            'edit'=>true,
            'form'=>$form->createView()
        ]);
    }
}
