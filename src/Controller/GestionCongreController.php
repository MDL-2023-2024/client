<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Vacation;
use App\Form\AteliersFormType;
use App\Form\ThemeFormType;
use App\Form\VacationFormType;
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
        $theme = new Theme();
        $vacation = new Vacation();

        $formAtelier = $this->createForm(AteliersFormType::class, $atelier);
        $formAtelier->handleRequest($request);

        $formTheme = $this->createForm(ThemeFormType::class, $theme);
        $formTheme->handleRequest($request);

        $formVacation = $this->createForm(VacationFormType::class, $vacation);
        $formVacation->handleRequest($request);
        return $this->render('gestion_congre/index.html.twig', [
            'atelierForm' => $formAtelier->createView(),
            'themeForm' => $formTheme->createView(),
            'vacationForm' => $formVacation->createView(),
        ]);
    }
}
