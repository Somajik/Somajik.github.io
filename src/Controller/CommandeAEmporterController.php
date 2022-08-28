<?php

namespace App\Controller;

use App\Entity\CommandeAEmporter;
use App\Entity\Plat;
use App\Entity\PlatJour;
use App\Repository\PlatRepository;
use App\Form\CommandeAEmporterType;
use App\Repository\FormuleRepository;
use App\Repository\CategoryRepository;
use App\Repository\PlatJourRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CommandeAEmporterRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/commande/a/emporter")
 */
class CommandeAEmporterController extends AbstractController
{
    /**
     * @Route("/", name="app_commande_a_emporter_index", methods={"GET"})
     */
    public function index(CommandeAEmporterRepository $commandeAEmporterRepository): Response
    {
        return $this->render('commande_a_emporter/index.html.twig', [
            'commande_a_emporters' => $commandeAEmporterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_commande_a_emporter_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CommandeAEmporterRepository $commandeAEmporterRepository,CategoryRepository $categoryRepository,PlatJourRepository $platJourRepository,PlatRepository $platRepository, FormuleRepository $formuleRepository): Response
    {
        $commandeAEmporter = new CommandeAEmporter();
        $form = $this->createForm(CommandeAEmporterType::class, $commandeAEmporter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $commandeAEmporterRepository->add($commandeAEmporter, true);
           
            return $this->redirectToRoute('app_commande_a_emporter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_a_emporter/new.html.twig', [
            'commande_a_emporter' => $commandeAEmporter,
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
            'plats' => $platRepository->findAll(),
            'plat_jours' => $platJourRepository->findAll(),
            'formules' => $formuleRepository->findAll(),
            
        ]);
    }

    /**
     * @Route("/{id}", name="app_commande_a_emporter_show", methods={"GET"})
     */
    public function show(CommandeAEmporter $commandeAEmporter): Response
    {
        return $this->render('commande_a_emporter/show.html.twig', [
            'commande_a_emporter' => $commandeAEmporter,
        ]);
    }

    
        /**
         * @Route("/aemporter", name="app_inscrit_index")
         */
        public function emporter(PlatRepository $platRepository, FormuleRepository $formuleRepository, CategoryRepository $categoryRepository, PlatJourRepository $platJourRepository): Response
        {
            return $this->render('carte_restaurant/index.html.twig', [
                'plats' => $platRepository->findAll(),
                'plat_jours' => $platJourRepository->findAll(),
                'categories' => $categoryRepository->findAll(),
                'formules' => $formuleRepository->findAll(),
            ]);
            
        }
    
    /**
     * @Route("/{id}/edit", name="app_commande_a_emporter_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CommandeAEmporter $commandeAEmporter, CommandeAEmporterRepository $commandeAEmporterRepository): Response
    {
        $form = $this->createForm(CommandeAEmporterType::class, $commandeAEmporter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeAEmporterRepository->add($commandeAEmporter, true);

            return $this->redirectToRoute('app_commande_a_emporter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_a_emporter/edit.html.twig', [
            'commande_a_emporter' => $commandeAEmporter,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_commande_a_emporter_delete", methods={"POST"})
     */
    public function delete(Request $request, CommandeAEmporter $commandeAEmporter, CommandeAEmporterRepository $commandeAEmporterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeAEmporter->getId(), $request->request->get('_token'))) {
            $commandeAEmporterRepository->remove($commandeAEmporter, true);
        }

        return $this->redirectToRoute('app_commande_a_emporter_index', [], Response::HTTP_SEE_OTHER);
    }
}
