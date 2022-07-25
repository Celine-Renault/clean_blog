<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    private CommentRepository $repo;

    public function __construct(CommentRepository $repo)
    {
      $this->repo = $repo;  
    }

    #[Route('/comment/create', name: 'comment.create')]
    public function create(): Response
    {
       
        $comments =  $this->repo->findAll();

        $newtab = [];
        return $this->json(['name' => 'test', 'comments' => $comments]);
      
    }

  
}
