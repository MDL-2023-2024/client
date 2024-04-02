<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Vacation;
use App\Form\AteliersFormType;
use App\Form\ThemeFormType;
use App\Form\VacationFormType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\False_;
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
        $atelierList = $entityManager->getRepository(Atelier::class)->findAll();
        
        if ($atelierList != null) {
            $theme = new Theme();
            $vacation = new Vacation();

            $formTheme = $this->createForm(ThemeFormType::class, $theme);
            $formTheme = $formTheme->handleRequest($request)->createView();

            $formVacation = $this->createForm(VacationFormType::class, $vacation);
            $formVacation = $formVacation->handleRequest($request)->createView();
        } else {
            $formTheme = null;
            $formVacation = null;
        }
        $formAtelier = $this->createForm(AteliersFormType::class, $atelier);
        $formAtelier->handleRequest($request);

        if ($formAtelier->isSubmitted() && $formAtelier->isValid()) {
            $entityManager->persist($atelier);
            $entityManager->flush();
            $this->addFlash('success', 'Atelier ajouté avec succès !');
            return $this->redirectToRoute('gestion_congre');
        }
        return $this->render('gestion_congre/index.html.twig', [
            'atelierForm' => $formAtelier->createView(),
            'themeForm' => $formTheme,
            'vacationForm' => $formVacation,
        ]);
    }
}
