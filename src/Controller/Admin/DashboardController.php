<?php

namespace App\Controller\Admin;

use App\Entity\Administrator;
use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/welcome.html.twig', [
            'dashboard_controller_filepath' => (new \ReflectionClass(static::class))->getFileName(),
            'dashboard_controller_class' => (new \ReflectionClass(static::class))->getShortName(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ma Classe');
    }

    public function configureMenuItems(): iterable

    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
        yield MenuItem::linkToCrud('Mes Classes', 'fa fa-chalkboard-teacher', Classe::class);
        yield MenuItem::linkToCrud('Mes Cours', 'fa fa-book-open',Cours::class );
        yield MenuItem::linkToCrud('Mes archives', 'fa fa-file-archive-o', Cours::class);
        yield MenuItem::subMenu('Utilisateurs', 'fa fa-user')->setSubItems([
            MenuItem::linkToCrud('Enseignants', 'fa fa-user', Enseignant::class),
            MenuItem::linkToCrud('Etudiants','fa fa-user',Etudiant::class),
        ]);
        }
}
