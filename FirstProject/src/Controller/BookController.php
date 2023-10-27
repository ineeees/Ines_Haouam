<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Entity\Author;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\BookType;
use App\Form\SearchType;
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/all', name: 'books_app')]
    public function listbooks(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findall(); 


        return $this->render('book/show.html.twig', [
            'books' => $books,
        ]);
    }
    #[Route('/book/add', name: 'add_book')]
    public function AddBook(ManagerRegistry $doctrine , Request $request ) 
    {
        $em=$doctrine->getManager();
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
        $em->persist($book);
        $em->flush();
        return $this->redirectToRoute('books_app');}
else  { 
    return  $this->renderForm('book/add.html.twig',['f'=> $form]) ;
 }
    }
    #[Route('/book/edit/{id}', name: 'edit_app')]
    public function EditBook($id , ManagerRegistry $doctrine , Request $request ) 
    {
        $em=$doctrine->getManager();
        $book = $doctrine->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
    
            $this->addFlash('success', 'book modifié');
    
            return $this->redirectToRoute('books_app'); 
        }
    
        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }
    #[Route('book/delete/{id}', name:'delete_app')]
    public function delete( $id , ManagerRegistry $doctrine) {
        $em=$doctrine ->getManager();
        $book = $doctrine->getRepository(Book::class)->find($id);
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('books_app');
    }
    #[Route('/book/list/search', name: 'app_book_search', methods: ['GET','POST'])]
    public function searchBook(Request $request,BookRepository $bookRepository): Response
    {   $book=new Book();
        $form=$this->createForm(SearchType::class,$book);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            return $this->render('book/search.html.twig', [
                'books' => $bookRepository->showAllBooksByAuthor($book->getTitle()),
                'f'=>$form->createView()
            ]);
        }
        return $this->render('book/search.html.twig', [
            'books' => $bookRepository->findAll(),
            'f'=>$form->createView()
        ]);
    }
}
