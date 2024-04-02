<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Form\AteliersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCongreController extends AbstractController
{
    #[Route('/gestionCongre', name: 'gestion_congre')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $atelier = new Atelier();
        $formAtelier = $this->createForm(AteliersType::class, $atelier);
        $formAtelier->handleRequest($request);
        return $this->render('gestion_congre/index.html.twig', [
            'atelierForm' => $formAtelier->createView(),
        ]);
    }
}
