<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Theme;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller permettant de gérer la page d'accueil.
 */
class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil.
     *
     * @param ManagerRegistry $doctrine Le gestionnaire d'entités.
     * @return Response La page d'accueil.
     */
    #[Route('/', name: 'acceuil')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $hotels = $doctrine->getRepository(Hotel::class)->findAll();
        $themes = $doctrine->getRepository(Theme::class)->findAll();
        return $this->render('home/index.html.twig', [
            'hotels' => $hotels,
            'themes' => $themes,
        ]);
    }
}
