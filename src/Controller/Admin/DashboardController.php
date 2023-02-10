<?php

namespace App\Controller\Admin;

use App\Entity\TimeZone;
use App\Entity\Application;
use App\Entity\Inventory;
use App\Entity\Silo;
use App\Entity\Customer;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
	$routeBuilder = $this->container->get(AdminUrlGenerator::class);
	$url = $routeBuilder->setController(InventoryCrudController::class)->generateUrl();

	return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Back to the website', 'fas fa-home', 'homepage');
        yield MenuItem::linkToCrud('Time Zone', 'fas fa-map-marker-alt', TimeZone::class);
        yield MenuItem::linkToCrud('Application', 'fas fa-map-marker-alt', Application::class);
        yield MenuItem::linkToCrud('Inventory', 'fas fa-map-marker-alt', Inventory::class);
        yield MenuItem::linkToCrud('Silo', 'fas fa-map-marker-alt', Silo::class);
        yield MenuItem::linkToCrud('Customer', 'fas fa-map-marker-alt', Customer::class);
    }
}
