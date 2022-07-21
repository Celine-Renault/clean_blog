<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use PhpParser\Builder\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[Route('/category/edit/{id}', name: 'category.edit', methods: ['POST'])]
    public function edit($id, Request $request): Response
    {
        $category = $this->repo->find($id); // je recupere la category avec son id

        $nom = trim($request->get('nom')); // je recupere le nom de la category avec l'input name et le get
        $submit = trim($request->get('submit'));

        if (isset($submit) && !empty($nom)) { // si le formulaire est envoye et si le nom, le champ n'est pas vide
            $category->setName($nom); // je modifie la category avec le set
            $this->repo->update(); // je la pousse dans la Base de donnee
            return $this->redirect('/category');
        }
        return $this->render('/category/edit.html.twig', ['category' => $category]);
    }

    #[IsGranted('ROLE_USER')] // pour limiter l'acces à l'ustilisateur, l'utilisateur pourra supprimer une category
    #[Route('/category/delete/{id}', name: 'category.delete', methods: ['POST'])]
    public function delete($id) // function delete pour supprimer une categorie
    {
        // $this->denyAccessUnlessGranted('ROLE_USER'); // methode denyAccessUnlessGranted pour bloquer l'acces à l'utilisateur qui n'est pas connecté
        $category = $this->repo->find($id);
        $posts = $category->getPost();
        // methode isEmpty pour verifier si la catégory ne contient pas de post
        // si la category ne contient pas de post on l'a supprime 
        if ($posts->isEmpty()) {
            $this->repo->remove($category, true);
        }
        return $this->redirect('/category');
    }

    #[IsGranted('ROLE_USER')] // pour limiter l'acces à l'ustilisateur, , l'utilisateur pourra creer une category
    #[Route('/category/create', name: 'category.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response // function create pour ajouter une category
    {
        // $this->denyAccessUnlessGranted('ROLE_USER'); // methode denyAccessUnlessGranted pour bloquer l'acces à l'utilisateur qui n'est pas connecté
        $category = new Category();
        $name = trim($request->get('name'));
        $submit = trim($request->get('submit'));

        if (isset($submit) && !empty($name)) {
            $category->setName($name);
            $this->repo->add($category, true);
            return $this->redirect('/category');
        }

        $categorys = $this->repo->findAll();
        return $this->render('/category/index.html.twig', ['categorys' => $categorys] );
    }

    #[Route('/category/{id}', name: 'category.show', methods: ['GET'])]
    public function show($id): Response
    {

        $category = $this->repo->find($id);
        $posts = $category->getPost();

        return $this->render('/category/show.html.twig', ['posts' => $posts, 'category' => $category]);
    }
}
