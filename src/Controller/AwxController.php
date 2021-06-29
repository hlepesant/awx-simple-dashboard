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


use App\Service\AwxGenerator;

class AwxController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'awx')]
    public function index(Request $request, AwxGenerator $awxGenerator, int $page=1): Response
    {
        $order_by = '-started';
        $page_size = 10;
        #if ($page == 0) $page = 1;

        $defaultData = ['page_size' => $page_size];
        $form = $this->createFormBuilder($defaultData)
            # ->add('page', HiddenType::class, [
            #     'data' => $page,
            # ])
            ->add('page_size', ChoiceType::class, [
                'label' => 'Items by page',
                'choices'  => [
                    10 => 10,
                    20 => 20, 
                    50 => 50
                ],
                'multiple' => false,
                'expanded' => false, 
                'attr' => ['class' => 'form-control form-control-sm'],
            ])
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $page_size = $data['page_size'];
            # $page = $data['page'];
        }

        $jobs = $awxGenerator->getAwxJobs($order_by, $page_size, $page);

        if ( empty($jobs) ) {
            return $this->redirectToRoute('awx');
        }

        $package = new PathPackage('/static/images', new StaticVersionStrategy('v1'));

        $previous_page = $this->generateUrl( 'awx', [
            'page' => ($page - 1),
        ]);

        $next_page = $this->generateUrl( 'awx', [
            'page' => ($page + 1),
        ]);

        return $this->render('awx/index.html.twig', [
            'logo' => $package->getUrl('logo-login.png'),
            'img_success' => $package->getUrl('confirm.png'),
            'img_failed' => $package->getUrl('cancel.png'),
            'img_console' => $package->getUrl('console.png'),
            'job_count' => $jobs['count'],
            'jobs' => $jobs['results'],

            'show_previous_button' => ($page > 1 ? true : false),
            'previous_page' => $previous_page,

            'next_page' => $next_page,
            'show_next_button' => ($page < ($jobs['count']/$page_size) ? true : false),

            'form' => $form->createView(),
        ]);
    }
}
