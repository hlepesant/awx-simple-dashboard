<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Asset\PathPackage;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Service\GitConfig;

class GitConfigController extends AbstractController
{
    #[Route('/config/get', name: 'git_clone')]
    public function clonerepo(Request $request, GitConfig $gitConfig): Response
    {
        $job = $gitConfig->getRepo();

        if ( $job === 0 ) { 
          return $this->redirectToRoute('git_show');
        } else {
          print "Error getting sources. Check your configuration !";
          exit;
        }
    }

    #[Route('/config', name: 'git_show')]
    public function index(Request $request, GitConfig $gitConfig): Response
    {
        $_envs = $gitConfig->getContent();

        $defaultData = ['env' => null];

        $form = $this->createFormBuilder($defaultData)
            ->add('env', ChoiceType::class, [
                'label' => 'Environment',
                'choices'  => $_envs,
                'multiple' => false,
                'expanded' => false, 
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          echo 'time to process files';
        }


/*
        foreach( $_envs as $_env ) {
          print_r($_env->getRelativePathname());
        }

        return $this->render('config/index.html.twig', [
            'controller_name' => 'GitConfigController',
        ]);
*/
        $package = new PathPackage('/static/images', new StaticVersionStrategy('v1'));
        
        return $this->render('config/index.html.twig', [
            'logo'                  => $package->getUrl('logo-login.png'),
            'form'                  => $form->createView(),
        ]);
    }
}
