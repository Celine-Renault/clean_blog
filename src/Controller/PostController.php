<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class PostController extends AbstractController
{

    private PostRepository $repo;
    public function __construct(PostRepository $repo)
    {
        $this->repo = $repo;
    }

    #[Route('/', name: 'post.index')]
    public function index(): Response
    {

        $posts = $this->repo->findAll();
       
        return $this->render('post/index.html.twig', ['posts' => $posts]);
    }
    #[Route('/post/create', name: 'post.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $post = new Post(); // creation de l'objet Post qui est vide pour le moment

        $form = $this->createForm(PostType::class, $post); //creation du formulaire qu'on place dans $form, il va s'afficher sur la page /post/create
        $form->handleRequest($request); // avec $request, je recupere les donnes de la requete quand j'ai envoyer le formulaire en appuyant sur le bouton valider/ok
        // dd($request);

        if ($form->isSubmitted() && $form->isValid()) { // condition si le formulaire est valider et envoyer
           $post->setCreatedAt(new DateTime()); // lorsqu'on valide le formulaire il le met à la date du jour, du moment ou on clique 
            $this->repo->add($post, true); // j'envoie les données vers la BD avec la methode add de PostRepository
            return $this->redirect('/'); // ensuite je redirige vers la vue/page des posts /
        }

        return $this->renderForm('post/create.html.twig', ['form' => $form]); // utiliser renderForm et non render // tableau associatif pour pouvoir recuperer les donnes rentrees dans le formulaire
    }

    #[Route('/post/{id}', name: 'post.show', methods: ['GET'])]
    public function show($id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $post = $this->repo->find($id); // je recupere 1 element
        
        return $this->render('/post/show.html.twig', ['post' => $post]);

    }

   
}
