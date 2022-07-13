<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    private ContactRepository $repo;

    public function __construct(ContactRepository $repo)
    {
        $this->repo = $repo;
    }


    #[Route('/contact', name: 'contact.index')]
    public function index(): Response
    {
       
        return $this->render('contact/create.html.twig');
    }

    #[Route('/contact/create', name: 'contact.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $submit = $request->get('submit');
        $errors = [];
        
      

        $name = trim($request->get('name'));
        if (empty($name)) {
            $errors['name'] = 'Le nom est requis !';
        }
        $email = trim($request->get('email'));
        if (empty($email)) {
            $errors['email'] = 'L\'email est requis !';
        }
        $telephone = trim($request->get('telephone'));
        if (empty($telephone)) {
            $errors['telephone'] = 'Le numéro de téléphone est requis !';
        }

        $message = trim($request->get('message'));
        if (empty($message)) {
            $errors['message'] = 'Le message est requis !';
        }

        $data = ['name' => $name, 'email' => $email, 'telephone' => $telephone, 'message' => $message]; // $data pour garder en mémoire ce qui a ete rempli dans l'input

        if (!isset($submit)) {
            return $this->render('contact/create.html.twig', ['data'=>$data]);
        }

        if (empty($errors)) {

            $contact = new Contact();

            $contact->setName($name);
            $contact->setEmail($email);
            $contact->setTelephone($telephone);
            $contact->setMessage($message);

            $this->repo->add($contact, true);

            return $this->redirect('/');
        } else {

            return $this->renderForm('/contact/create.html.twig', ['errors' => $errors, 'data' => $data]);
        }
    }
}
