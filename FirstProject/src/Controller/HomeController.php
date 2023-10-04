<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    #[Route('/home', name: 'home_index')]
    public function index(): Response
    {
        $message = 'Bonjour mes étudiants';

        return new Response($message);
    }
    }

?>