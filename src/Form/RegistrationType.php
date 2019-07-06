<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,['attr'=>['class'=>'form-control']])
            ->add('password',RepeatedType::class,['type'=>PasswordType::class,
            'invalid_message'=> 'Les mots de passe dois devenir identique',
            'required'=>true,
            'first_options'=>['label'=> 'Mot de passe','attr'=>['class'=>'form-control']],
            'second_options' => ['label'=> 'répéter le mot de passe','attr'=>['class'=>'form-control']],
           
            ])
            ->add('inscrire',SubmitType::class,['attr'=>['class'=>'btn btn-primary rounded float-right','type'=>'submit']])
            ->add('add',SubmitType::class,['attr'=>['type'=>'submit']   ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
