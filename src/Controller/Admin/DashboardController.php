<?php

namespace App\Controller\Admin;


use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdmin/welcome.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sortir Com');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Participants', 'fas fa-user', Participant::class);
        yield MenuItem::linkToCrud('Sorties', 'fas fa-arrow-right', Sortie::class);
        yield MenuItem::linkToCrud('Campus', 'fas fa-building', Campus::class);
    }
}
