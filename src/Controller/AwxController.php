<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Asset\PathPackage;

use App\Service\AwxGenerator;

class AwxController extends AbstractController
{
    #[Route('/', name: 'awx')]
    public function index(AwxGenerator $awxGenerator): Response
    {
        $package = new PathPackage('/static/images', new StaticVersionStrategy('v1'));

        # $_password = 'kL7tZEtdxHuAhdV';
        # $_username = 'symfony';
        # TOWER_USERNAME=$_username TOWER_PASSWORD=$_password TOWER_HOST=http://127.0.0.1/ awx login
	    $_token = "hc5FIGZuwhIUEkmJASA45qM60dgb18";


        $jobs = $awxGenerator->getAwxJobs($_token);
        # print_r($jobs['results'][0]); exit;

        return $this->render('awx/index.html.twig', [
            'logo' => $package->getUrl('logo-login.png'),
            'img_success' => $package->getUrl('confirm.png'),
            'img_failed' => $package->getUrl('cancel.png'),
            'job_count' => $jobs['count'],
            'jobs' => $jobs['results'],
        ]);
    }
}
