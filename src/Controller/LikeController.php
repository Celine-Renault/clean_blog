<?php

namespace App\Controller;

use App\Entity\Like;
use App\Repository\PostRepository;
use App\Repository\LikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{

    private PostRepository $pRepo;
    private LikeRepository $lRepo;

    public function __construct( PostRepository $pRepo, LikeRepository $lRepo)
    {
        $this->pRepo = $pRepo;
        $this->lRepo = $lRepo;
    }

    #[Route('/like/create/{postId}', name: 'like.create')]
    public function create($postId, Request $request): Response
    {
        // dd('ici');
        $this->denyAccessUnlessGranted('ROLE_USER');

        $post = $this->pRepo->find($postId);

        $like = $this->lRepo->findOneBy(['post'=>$post,'user'=>$this->getUser()]); // $this->getUser() pour savoir si l'utilisateur est connecté 

        if($like==null){ // ou if($like) c'est pareil par defaut $like est null
            // ajouter un like
         $like = new Like();
         $like->setUser($this->getUser());
         $like->setPost($post); 

         $this->lRepo->add($like, true);
        
        }else{
        // supprimer un like
        $this->lRepo->remove($like, true);
        }

        $nbLikes = count($post->getLikes());

        return $this->json(['nbLikes'=>$nbLikes]); // data dans json correspon au nbLikes et la methode json() retourne un objet
    }
}

