<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    private CategoryRepository $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    // #[Route('/category', name: 'category.index')]
    // public function index(): Response
    // {

    //     $categorys = $this->repo->findAll();
    //     return $this->render('category/index.html.twig', ['categorys'=>$categorys]);
    // }

    #[Route('/category/{id}', name: 'category.show', methods:['GET'])]
    public function show($id): Response{

        $category = $this->repo->find($id);
        $posts = $category->getPost();

        return $this->render('/catgory/show.html.twig', ['posts'=>$posts]);
    } 
}
