<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Form\ReservationType;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
    #[Route('/reservation/add', name: 'add_reservation')]
    public function AddReservation(ManagerRegistry $doctrine , Request $request) 
{
        $em=$doctrine->getManager();
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            
        $em->persist($reservation);
        $em->flush();
     
        return $this->redirectToRoute('vol_app');}
else  { 
    return  $this->renderForm('reservation/add.html.twig',['f'=> $form]) ;
 }
}
}