<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Repository\FormuleRepository;
use App\Repository\CategoryRepository;
use App\Repository\PlatJourRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarteRestaurantController extends AbstractController
{
    /**
     * @Route("/carte/restaurant", name="app_carte_restaurant")
     */
    public function index(PlatRepository $platRepository, FormuleRepository $formuleRepository, CategoryRepository $categoryRepository, PlatJourRepository $platJourRepository): Response
    {
        return $this->render('carte_restaurant/index.html.twig', [
            'plats' => $platRepository->findAll(),
            'plat_jours' => $platJourRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'formules' => $formuleRepository->findAll(),
        ]);
        
    }
}
