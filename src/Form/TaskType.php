<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TaskType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
        $builder->add('title', TextType::class)
                ->add('content', TextType::class)
                ->add('priority', ChoiceType::class, [
                    'choices' => [
                        'Alt' => 'alt',
                        'Mig' => 'mig',
                        'Baix' => 'baix'
                    ]
                ])
                ->add('hours', IntegerType::class)
                ->add('submit',SubmitType::class,[
                    'label' => 'Crear tasca'
                ]);
                
    }
}