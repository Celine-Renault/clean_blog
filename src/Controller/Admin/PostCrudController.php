<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\TextEditorField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')] // pour limiter l'acces a l'administrateur
class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         IdField::new('id'),
    //         TextField::new('title'),
    //         TextEditorField::new('description'),
    //     ];
    // }
}
