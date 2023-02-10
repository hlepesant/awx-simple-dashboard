<?php

namespace App\Controller\Admin;

use App\Entity\TimeZone;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TimeZoneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TimeZone::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
