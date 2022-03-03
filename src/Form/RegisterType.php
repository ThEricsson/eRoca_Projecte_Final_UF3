<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
        $builder->add('name', TextType::class)
                ->add('surname', TextType::class)
                ->add('email', TextType::class)
                ->add('password', PasswordType::class)
                ->add('submit',SubmitType::class,[
                    'label' => 'Registrar usuari'
                ]);
                
    }
}