<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_EDITOR')] // pour limiter l'acces  au redacteur editor et a l'administrateur par heritage
class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //    ->setEntityLabelInSingular('Category Post')
            ->setSearchFields(['id', 'Titre', 'category']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('Titre')
            ->add('category');
           
    }

    public function configureFields(string $pageName): iterable
    {
        //     return [
        //         IdField::new('id'),
        //         TextField::new('title'),
        //         TextEditorField::new('description'),
        //     ];
        return [
            yield AssociationField::new('category'),
            // yield IdField::new('id'),
            yield TextField::new('titre'),
            yield DateField::new('createdAt'),
            yield TextEditorField::new('description'),
            yield TextEditorField::new('contenu'),
            yield ImageField::new('imageFileName')->setBasePath('uploads/images/')->setUploadDir('public/uploads/images')
        ];
    }
}
