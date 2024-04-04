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

            $this->getErrors($formTheme->getErrors(true));
            $this->getErrors($formVacation->getErrors(true));

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

        $this->getErrors($formAtelier->getErrors(true));

        return $this->render('gestion_congre/add_congre.html.twig', [
            'atelierForm' => $formAtelier->createView(),
            'themeForm' => isset($formTheme) ? $formTheme->createView() : null,
            'vacationForm' => isset($formVacation) ? $formVacation->createView() : null,
        ]);
    }

    #[Route('/editVacation', name: 'edit_vacation')]
    public function editVacation(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $vacations = $entityManager->getRepository(Vacation::class)->findAll();
        try {
            $vacation = $entityManager->getRepository(Vacation::class)->find($request->get('id'));
        }
        catch (\Exception $e) {
            $vacation = $vacations[0];
        }

        $formVacation = $this->createForm(VacationFormType::class, $vacation,  [
            'action' => $this->generateUrl('gestion_edit_vacation_idgiven', array('id' => $vacation->getId())),
        ]);
        $formVacation = $formVacation->handleRequest($request);

        return $this->render('gestion_congre/edit_vacation.html.twig', [
            'vacations' => $vacations,
            'vacationid' => $vacation->getId(),
            'vacationForm' => $formVacation->createView(),
        ]);
    }

    #[Route('/editVacation/{id}', name: 'edit_vacation_idgiven')]
    public function editVacationId(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $vacation = $entityManager->getRepository(Vacation::class)->find($request->get('id'));
        $formVacation = $this->createForm(VacationFormType::class, $vacation, [
            'action' => $this->generateUrl('gestion_edit_vacation_idgiven', array('id' => $vacation->getId())),
        ]);
        $formVacation->handleRequest($request);

        if ($formVacation->isSubmitted() && $formVacation->isValid()) {
            $entityManager->persist($vacation);
            $entityManager->flush();
            $this->addFlash('success', 'Vacation ajoutée avec succès !');
            return $this->redirectToRoute('gestion_edit_vacation', array('id' => $vacation->getId()));
        }
        $errors = [];
        $errors += $this->getErrors($formVacation->getErrors(true));
        if (count($errors) > 0) {
            return $this->redirectToRoute('gestion_edit_vacation', array('id' => $vacation->getId()));
        }	
        return $this->render('gestion_congre/form/vacationForm.html.twig', [
            'vacationForm' => $formVacation->createView(),
            'id' => $vacation->getId(),
            'show' => true,
        ]);
    }

    private function getErrors($formError)
    {
        $errors = [];
        if ($formError instanceof FormError) {
            $errors[] = $formError->getMessage();
            $this->addFlash('error', $formError->getMessage());
        } elseif ($formError instanceof FormErrorIterator) {
            foreach ($formError as $error) {
                $this->addFlash('error', $error->getMessage());
                $errors[] = $error->getMessage();
            }
        }
        return $errors;
    }
}
