<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AuthorType;
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
    #[Route('/all', name: 'author_app')]
    public function listAuthors(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll(); 

        return $this->render('author/authorshow.html.twig', [
            'authors' => $authors,
        ]);
    }
    #[Route('/add', name: 'add')]
    public function AddAuthor(ManagerRegistry $doctrine , Request $request  ) 
    {
        $em=$doctrine ->getManager();
        $author = new Author();
      /*  $author->setUsername("ines");
        $author->setEmail("ines.haoua@esprit.tn"); */ 
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('author_app');}
else  { 
    return  $this->renderForm('author/add.html.twig',['f'=> $form]) ;
 }
    }
    #[Route('/delete/{id}', name:'delete')]
    public function delete( $id , ManagerRegistry $doctrine) {
        $em=$doctrine ->getManager();
        $author = $doctrine->getRepository(Author::class)->find($id);
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('author_app');
    }
    #[Route('/edit/{id}', name: 'edit_app')]
public function edit($id, ManagerRegistry $doctrine, Request $request)
{
    $em = $doctrine->getManager();
    $author = $doctrine->getRepository(Author::class)->find($id);

    if (!$author) {
        throw $this->createNotFoundException("L'auteur n'existe pas");
    }

    $form = $this->createForm(AuthorType::class, $author); 
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        $this->addFlash('success', 'Auteur modifié');

        return $this->redirectToRoute('author_app'); 
    }

    return $this->render('author/edit.html.twig', [
        'author' => $author,
        'form' => $form->createView(),
    ]);
}
#[Route('/tri', name: 'author')]
public function listAuthorsparusername(AuthorRepository $authorRepository): Response
{
    $authors = $authorRepository->triQBL(); 

    return $this->render('author/authorshow.html.twig', [
        'authors' => $authors,
    ]);
}
#[Route('/tridsc', name: 'author_tri')]
public function listAuthorsdescendantparusername(AuthorRepository $authorRepository): Response
{
    $authors = $authorRepository->triDBL(); 

    return $this->render('author/authorshow.html.twig', [
        'authors' => $authors,
    ]);
}

    
}
