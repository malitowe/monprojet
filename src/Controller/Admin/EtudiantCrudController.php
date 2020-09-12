<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EtudiantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etudiant::class;
    }


//    public function configureFields(string $pageName): iterable
//    {
//        yield Field\IdField::new('id')->hideOnForm();
//        yield Field\TextField::new('fullName', 'user.label.fullName')->onlyOnIndex();
//
//    }
}

