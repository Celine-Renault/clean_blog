<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_MODERATOR')]
class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        // ->add('id')
        // si je veux filtrer avec la class User sui est une clé étrangere je dois surcharger la class User avec la methode __toString() return $this->username;
        ->add('User') 
        // si je veux filtrer avec la class Post sui est une clé étrangere je dois surcharger la class Post avec la methode __toString() return $this->Titre;
        ->add('Post')
        ->add('createdAt');
    }

    
    public function configureFields(string $pageName): iterable
    {
        // return [
        //     IdField::new('id'),
        //     TextField::new('title'),
        //     TextEditorField::new('description'),
        // ];

        return [
            yield IdField::new('id'),
            yield AssociationField::new('User'),
            yield AssociationField::new('Post'),
            yield TextField::new('content'),
            yield DateTimeField::new('createdAt'),
        ];
    }
   
}
