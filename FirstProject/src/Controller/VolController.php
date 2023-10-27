<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vol;
use App\Repository\VolRepository;

class VolController extends AbstractController
{
    #[Route('/vol', name: 'app_vol')]
    public function index(): Response
    {
        return $this->render('vol/index.html.twig', [
            'controller_name' => 'VolController',
        ]);
    }
    #[Route('/vol/all', name: 'vol_app')]
    public function listvol(VolRepository $volRepository): Response
    {
        $vols = $volRepository->findall(); 


        return $this->render('vol/show.html.twig', [
            'vols' => $vols,
        ]);
    }
 


}