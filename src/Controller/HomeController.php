<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/home/about', name: 'home.about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('/home/about.html.twig');
    }

    #[Route('/contact/contact', name: 'home.contact', methods: ['GET'])]
    public function contact(): Response
    {
        return $this->render('/contact/create.html.twig');
    }

}
