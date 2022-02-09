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

use App\Form\Type\ConfigType;
use App\Service\GitConfig;
use App\Entity\ConfOpts;

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
        $_env = null;
        $_app = null;
        $_stack = null;
        $_client = null;
        $_full_config = array();

        if ($request->isMethod('POST')) {
            if ( null !== $request->get('config') )  {

                $config = $request->get('config');

                if ( array_key_exists('env', $config) ) $_env = $config['env'];
                if ( array_key_exists('app', $config) ) $_app = $config['app'];
                if ( array_key_exists('stack', $config) ) $_stack = $config['stack'];
                if ( array_key_exists('client', $config) ) $_client = $config['client'];

                if ( $_env && $_app && $_stack && $_client ) {

                    $_app_default = $gitConfig->getAppDefault($_env, $_app);
                    $_stack_default = $gitConfig->getStackDefault($_env, $_app, $_stack);
                    $_client_main = $gitConfig->getClientMain($_env, $_app, $_stack, $_client);

                    $_full_config = array_merge( $_app_default, $_stack_default, $_client_main);
                }
            }
        }

        $conf = new ConfOpts();

        $form = $this->createForm(ConfigType::class, $conf, array(
            'env_choices' => $gitConfig->getEnvironments(),
            'app_choices' => $gitConfig->getApplications($_env),
            'stack_choices' => $gitConfig->getStacks($_env, $_app),
            'client_choices' => $gitConfig->getClients($_env, $_app, $_stack)
        ));

        if ($form->isSubmitted() && $form->isValid()) {
            $conf = $form->getData();
            print_r($conf);
            exit;
        }

        $form->handleRequest($request);

        $package = new PathPackage('/static/images', new StaticVersionStrategy('v1'));

        return $this->renderForm('config/index.html.twig', [
            'logo'                  => $package->getUrl('logo-login.png'),
            'form'                  => $form,
            'options'               => $_full_config,
        ]);
    }
}
