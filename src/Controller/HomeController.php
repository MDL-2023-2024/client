<?php

namespace App\Controller;

use App\Entity\Hotel;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'acceuil')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $hotels = $doctrine->getRepository(Hotel::class)->findAll();
        return $this->render('home/index.html.twig', [
            'hotels' => $hotels,
        ]);
    }
}
