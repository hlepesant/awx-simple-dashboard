<?php

namespace App\Controller\Admin;

use App\Entity\AwxJob;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class AwxJobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AwxJob::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Customer AwxJob')
            ->setEntityLabelInPlural('Customer AwxJobs')
            ->setEntityLabelInSingular('Application AwxJob')
            ->setEntityLabelInPlural('Application AwxJobs')
            ->setSearchFields(['awx_template', 'text', 'awx_template'])
            ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('customer'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('customer');
        yield AssociationField::new('application');

        $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
            'html5' => true,
            'years' => range(date('Y'), date('Y') + 5),
            'widget' => 'single_text',
        ]);

        if (Crud::PAGE_EDIT === $pageName) {
            yield $createdAt->setFormTypeOption('disabled', true);
        } else {
            yield $createdAt;
        }
    }
}
