<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EnseignantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Enseignant::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('sexe'),
            TextField::new('username'),
            //TextField::new('password'),
            //DateTimeField::new('dateNaissance'),
            DateTimeField::new('created_at'),
            DateTimeField::new('updated_at'),
            BooleanField::new('active'),
            //DateTimeField::new('lastLogin'),
        ];
    }
    
}
