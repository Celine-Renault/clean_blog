<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
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

    #[Route('/category', name: 'category.index')]
    public function index(): Response
    {

        $categorys = $this->repo->findAll();

        return $this->render('category/index.html.twig', ['categorys' => $categorys]);
    }

    #[Route('/category/edit/{id}', methods: ['POST'])]
    public function update($id)
    {
        $category = $this->repo->find($id);
        $this->repo->update($category);

        return $this->redirect('/category');
    }

    #[Route('/category/delete/{id}', name: 'category.delete', methods: ['POST'])]
    public function delete($id)
    {
        $category = $this->repo->find($id);
        $posts = $category->getPost();
        // methode isEmpty pour verifier si la catégory ne contient pas de post
        // si la category ne contient pas de post on l'a supprime 
        if($posts->isEmpty()){
            $this->repo->remove($category, true);
        }
        return $this->redirect('/category');
    }

    #[Route('/category/create', name: 'category.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {

        $category = new Category();
        $name = trim($request->get('name'));
        $category->setName($name);
        $this->repo->add($category, true);

        return $this->redirect('/category');

        //     $submit = $request->get('submit');
        //     $errors = [];

        //     $name = trim($request->get('name'));
        //     if (empty($name)) {
        //         $errors['name'] = 'La catégorie est requise !';
        //     }

        //     if (!isset($submit)) {
        //         return $this->render('category/create.html.twig');
        //     }

        //     if (empty($errors)) {
        //     $category = new Category(); 

        //     $category->setName($name);
        //     $this->repo->add($category, true);

        //     return $this->render('/category/index.html.twig');

        // }

        // $form = $this->createForm(CategoryType::class, $category); 
        // $form->handleRequest($request); 

        // return $this->renderForm('/category/create.html.twig');
    }

    // #[Route('/category/{id}', name: 'category.show', methods: ['GET'])]
    // public function show($id): Response
    // {

    //     $category = $this->repo->find($id);
    //     $posts = $category->getPost();

    //     return $this->render('/category/show.html.twig', ['posts' => $posts, 'category' => $category]);
    // }
}
