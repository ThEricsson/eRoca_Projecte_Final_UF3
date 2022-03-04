<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
        $builder->add('title', TextType::class)
                ->add('content', TextType::class)
                ->add('priority', TextType::class)
                ->add('hours', IntegerType::class)
                ->add('submit',SubmitType::class,[
                    'label' => 'Registrar usuari'
                ]);
                
    }
}