<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Service\FileUploader;
use App\Repository\PlatRepository;
use App\Repository\FormuleRepository;
use App\Repository\CategoryRepository;
use App\Repository\PlatJourRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/plat")
 */
class PlatController extends AbstractController
{
    /**
     * @Route("/", name="app_plat_index", methods={"GET"})
     */
    public function index(PlatRepository $platRepository, CategoryRepository $categoryRepository, FormuleRepository $formuleRepository, PlatJourRepository $platJourRepository): Response
    {
        return $this->render('plat/index.html.twig', [
            'plats' => $platRepository->findAll(),
            'formules' => $formuleRepository->findAll(),
            'category' => $categoryRepository->findAll(),
            'plat_jours' => $platJourRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_plat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PlatRepository $platRepository, FileUploader $fileUploader): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // traitement upload
            $image =$form->get('images')->getData();
            if($image){
                $fileName = $fileUploader->upload($image);
                $plat->setImage($fileName);
                
            }
            $platRepository->add($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat/new.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_plat_show", methods={"GET"})
     */
    public function show(Plat $plat): Response
    {
        return $this->render('plat/show.html.twig', [
            'plat' => $plat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_plat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Plat $plat, PlatRepository $platRepository): Response
    {
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $platRepository->add($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat/edit.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_plat_delete", methods={"POST"})
     */
    public function delete(Request $request, Plat $plat, PlatRepository $platRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $platRepository->remove($plat, true);
        }

        return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
    }
}
