<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/showauthor/{name}', name: 'show')]
    public function showAuthor($name):Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }
    #[Route('/list', name: 'list_app')]
    public function list():Response {
      
    return $this->render('author/list.html.twig', [
        'authors' => $this-> authors,
    ]);
}
#[Route('/details/{id}', name: 'detail_app')]
public function authorDetails($id) : Response {
        $author = null;
        foreach ($this->authors as $a) {
            if ($a['id'] == $id) {
                $author = $a;
                break;
            }
        }
        if ($author === null) {
            return new Response('Author not found', Response::HTTP_NOT_FOUND);
        }
        return $this->render('author/showauthor.html.twig', [
            'author' => $author,
        ]);
    }
}
