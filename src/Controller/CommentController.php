<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use DateTime;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
  private CommentRepository $cRepo;
  private PostRepository $pRepo;

  public function __construct(CommentRepository $cRepo, PostRepository $pRepo)
  {
    $this->cRepo = $cRepo;
    $this->pRepo = $pRepo;
  }

  #[IsGranted('ROLE_USER')]
  #[Route('/comment/create/{postId}', name: 'comment.create')]
  public function create($postId, Request $request, CommentRepository $cRepo): Response
  {

    $post = $this->pRepo->find($postId); // je recupere le post avec postId

    $commentBody = $request->toArray(); // $commentBody est un tableau il recupere le commentaire

    $comment = new Comment;
    $comment->setCreatedAt(new DateTime());
    $comment->setContent($commentBody['textareaComment']);
    $comment->setUser($this->getUser()); // this appelle une methode getUser qui vient du controller CommentController et de son parent AbstractController
    $comment->setPost($post);
    dd($comment);
    $cRepo->add($comment, true); // j'ajoute le commentaire dans la BD


    $comments = $post->getComments(); // dans l'entité Post j'ai la methode getComments() qui me permet de recuperer tous les commentaires associé à ce post

    // $comments =  $this->CommentRepo->findAll(); // je recupere la liste des commentaire depuis la BD c'est un tableau
    $allComments = []; // on ajoute chaque commentaire dans ce tableau

    foreach ($comments as $comment) { // TABLEAU AS les ELEMENTS DES TABLEAU, IL PEUT AUSSI Y AVOIR LES CLES ET LES VALEURS A DROITE du tableau apres le AS

      // je parcours le tableau pour recuperer tous les commentaires
      $allComments[] = [

        'id' => $comment->getId(),
        'content' => $comment->getContent(),
        'createdAt' => $comment->getCreatedAt(),
      ];
    }
    return $this->json($allComments);
  }
}
