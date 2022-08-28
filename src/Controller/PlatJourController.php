<?php

namespace App\Controller;

use App\Entity\PlatJour;
use App\Form\PlatJourType;
use App\Service\FileUploader;
use App\Repository\PlatRepository;
use App\Repository\PlatJourRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/platjour")
 */
class PlatJourController extends AbstractController
{
    /**
     * @Route("/", name="app_plat_jour_index", methods={"GET"})
     */
    public function index(PlatJourRepository $platJourRepository, PlatRepository $platRepository): Response
    {
        return $this->render('plat_jour/index.html.twig', [
            'plat_jours' => $platJourRepository->findAll(),
            'plats' => $platRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_plat_jour_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PlatJourRepository $platJourRepository, FileUploader $fileUploader): Response
    {
        $platJour = new PlatJour();
        $form = $this->createForm(PlatJourType::class, $platJour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // traitement upload

            $platJourRepository->add($platJour, true);

            return $this->redirectToRoute('app_plat_jour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat_jour/new.html.twig', [
            'plat_jour' => $platJour,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_plat_jour_show", methods={"GET"})
     */
    public function show(PlatJour $platJour): Response
    {
        return $this->render('plat_jour/show.html.twig', [
            'plat_jour' => $platJour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_plat_jour_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PlatJour $platJour, PlatJourRepository $platJourRepository): Response
    {
        $form = $this->createForm(PlatJourType::class, $platJour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $platJourRepository->add($platJour, true);

            return $this->redirectToRoute('app_plat_jour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat_jour/edit.html.twig', [
            'plat_jour' => $platJour,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_plat_jour_delete", methods={"POST"})
     */
    public function delete(Request $request, PlatJour $platJour, PlatJourRepository $platJourRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$platJour->getId(), $request->request->get('_token'))) {
            $platJourRepository->remove($platJour, true);
        }

        return $this->redirectToRoute('app_plat_jour_index', [], Response::HTTP_SEE_OTHER);
    }
}
