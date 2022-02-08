<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Service\GitConfig;

class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*
        $defaultData = [
          'env' => null,
          'app' => null,
          'stack' => null,
          'client' => null
        ];
         */

        $builder
            ->add('env', ChoiceType::class, [
                'label' => 'Environment',
                'choices' => $options['env_choices'],  
                'multiple' => false,
                'expanded' => false, 
                'required' => false,
                'empty_data' => '-- select --',
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('app', ChoiceType::class, [
                'label' => 'Application',
                'choices' => $options['app_choices'],  
                'multiple' => false,
                'expanded' => false, 
                'required' => false,
                'empty_data' => '-- select --',
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('stack', ChoiceType::class, [
                'label' => 'Stack',
                'choices' => $options['stack_choices'],  
                'multiple' => false,
                'expanded' => false, 
                'required' => false,
                'empty_data' => '-- select --',
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('client', ChoiceType::class, [
                'label' => 'Client',
                'choices' => $options['client_choices'],  
                'multiple' => false,
                'expanded' => false, 
                'required' => false,
                'empty_data' => '-- select --',
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            // ->add('send', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'env_choices' => array(),
            'app_choices' => array(),
            'stack_choices' => array(),
            'client_choices' => array()
        ]);
    }
}
