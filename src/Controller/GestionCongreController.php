<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Vacation;
use App\Form\AteliersFormType;
use App\Form\ThemeFormType;
use App\Form\VacationFormType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gestion', name: 'gestion_')]
#[IsGranted("ROLE_USER")]
class GestionCongreController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('gestion_congre/index.html.twig');
    }   

    #[Route('/new', name: 'add')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {

        $errors = [];
        $entityManager = $doctrine->getManager();
        $atelier = new Atelier();
        $atelierList = $entityManager->getRepository(Atelier::class)->findAll();

        if ($atelierList != null) {
            $theme = new Theme();
            $vacation = new Vacation();

            $formTheme = $this->createForm(ThemeFormType::class, $theme);
            $formTheme = $formTheme->handleRequest($request);

            $formVacation = $this->createForm(VacationFormType::class, $vacation);
            $formVacation = $formVacation->handleRequest($request);
            
            $errors += $this->getErrors($formTheme->getErrors(true));
            $errors += $this->getErrors($formVacation->getErrors(true));

            if ($formTheme->isSubmitted() && $formTheme->isValid()) {
                $entityManager->persist($theme);
                $entityManager->flush();
                $this->addFlash('success', 'Thème ajouté avec succès !');
                return $this->redirectToRoute('gestion_add');
            }

            if ($formVacation->isSubmitted() && $formVacation->isValid()) {
                $entityManager->persist($vacation);
                $entityManager->flush();
                $this->addFlash('success', 'Vacation ajoutée avec succès !');
                return $this->redirectToRoute('gestion_add');
            }
        }
        $formAtelier = $this->createForm(AteliersFormType::class, $atelier);
        $formAtelier->handleRequest($request);

        if ($formAtelier->isSubmitted() && $formAtelier->isValid()) {
            $entityManager->persist($atelier);
            $entityManager->flush();
            $this->addFlash('success', 'Atelier ajouté avec succès !');
            return $this->redirectToRoute('gestion_add');
        }


        $errors += $this->getErrors($formAtelier->getErrors(true));

        return $this->render('gestion_congre/add_congre.html.twig', [
            'atelierForm' => $formAtelier->createView(),
            'themeForm' => isset($formTheme) ? $formTheme->createView() : null,
            'vacationForm' => isset($formVacation) ? $formVacation->createView() : null,
            'errors' => $errors,
        ]);
    }

    #[Route('/editVacation', name: 'edit_vacation')]
    public function editVacation(Request $request, ManagerRegistry $doctrine): Response
    {
        $vacation = new Vacation();
        $entityManager = $doctrine->getManager();
        $formVacation = $this->createForm(VacationFormType::class, $vacation);
        $formVacation->handleRequest($request);

        if ($formVacation->isSubmitted() && $formVacation->isValid()) {
            $entityManager->persist($vacation);
            $entityManager->flush();
            $this->addFlash('success', 'Vacation modifiée avec succès !');
            return $this->redirectToRoute('gestion_edit_vacation');
        }

        return $this->render('gestion_congre/edit_vacation.html.twig', [
            'vacationForm' => $formVacation->createView(),
        ]);
    }

    #[Route('/editVacation/{id}', name: 'edit_vacation_idgiven')]
    public function editVacationId(Request $request, ManagerRegistry $doctrine): Response
    {
        $vacation = new Vacation();
        $entityManager = $doctrine->getManager();
        $formVacation = $this->createForm(VacationFormType::class, $vacation);
        $formVacation->handleRequest($request);

        if ($formVacation->isSubmitted() && $formVacation->isValid()) {
            $entityManager->persist($vacation);
            $entityManager->flush();
            $this->addFlash('success', 'Vacation modifiée avec succès !');
            return $this->redirectToRoute('gestion_edit_vacation');
        }

        return $this->render('gestion_congre/edit_vacation.html.twig', [
            'vacationForm' => $formVacation->createView(),
        ]);
    }

    private function getErrors($formError)
    {
        $errors = [];
        if ($formError instanceof FormError) {
            $errors[] = $formError->getMessage();
        } elseif ($formError instanceof FormErrorIterator) {
            foreach ($formError as $error) {
                $errors[] = $error->getMessage();
            }
        }
        return $errors;
    }
}
