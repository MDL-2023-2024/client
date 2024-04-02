<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Vacation;
use App\Form\AteliersFormType;
use App\Form\ThemeFormType;
use App\Form\VacationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Error;
use Exception;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Error\UndefinedMethodError;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionCongreController extends AbstractController
{
    #[Route('/gestionCongre', name: 'gestion_congre')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
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

            if ($formTheme->isSubmitted() && $formTheme->isValid()) {
                $entityManager->persist($theme);
                $entityManager->flush();
                $this->addFlash('success', 'Thème ajouté avec succès !');
                return $this->redirectToRoute('gestion_congre');
            }

            if ($formVacation->isSubmitted() && $formVacation->isValid()) {
                $entityManager->persist($vacation);
                $entityManager->flush();
                $this->addFlash('success', 'Vacation ajoutée avec succès !');
                return $this->redirectToRoute('gestion_congre');
            }
        }
        $formAtelier = $this->createForm(AteliersFormType::class, $atelier);
        $formAtelier->handleRequest($request);

        if ($formAtelier->isSubmitted() && $formAtelier->isValid()) {
            $entityManager->persist($atelier);
            $entityManager->flush();
            $this->addFlash('success', 'Atelier ajouté avec succès !');
            return $this->redirectToRoute('gestion_congre');
        }

        $errors = [];
        $errors += $this->getErrors($formAtelier->getErrors(true));
        $errors += $this->getErrors($formTheme->getErrors(true));
        $errors += $this->getErrors($formVacation->getErrors(true));

        return $this->render('gestion_congre/index.html.twig', [
            'atelierForm' => $formAtelier->createView(),
            'themeForm' => isset($formTheme) ? $formTheme->createView() : null,
            'vacationForm' => isset($formVacation) ? $formVacation->createView() : null,
            'errors' => $errors,
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
