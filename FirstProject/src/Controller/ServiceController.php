<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service')]

        public function showService($name)
        {
            
        return $this->render('service/index.html.twig', [
            'name' => $name,
        ]);
          }
#[Route('/GoToIndex', name: 'GoToIndex')]
public function goToIndex () : RedirectResponse {
    return $this->redirectToRoute('home_index');
}
}