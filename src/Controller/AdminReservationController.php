<?php

namespace App\Controller;

use App\Entity\AdminReservation;
use App\Form\AdminReservationType;
use App\Repository\AdminReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class AdminReservationController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_reservation_index", methods={"GET"})
     */
    public function index(AdminReservationRepository $adminReservationRepository): Response
    {
        $user = $this->getUser();
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $adminReservations = $adminReservationRepository->findAll();
        } else {
            $adminReservations = $adminReservationRepository->findBy(['reference_reservation' => $user,]);
        }
        return $this->render('admin_reservation/index.html.twig', [
            'admin_reservations' => $adminReservations,
        ]);
    }

    /**
     * @Route("/new", name="app_admin_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AdminReservationRepository $adminReservationRepository): Response
    {
        $adminReservation = new AdminReservation();
        $form = $this->createForm(AdminReservationType::class, $adminReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \Datetime("now");
            $user = $this->getUser();
            $adminReservation->setDateCreation($date);
            $adminReservation->setReferenceReservation($user);
            $adminReservation->setStatus("En cours");

            $adminReservationRepository->add($adminReservation, true);

            return $this->redirectToRoute('app_admin_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_reservation/new.html.twig', [
            'admin_reservation' => $adminReservation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_reservation_show", methods={"GET"})
     */
    public function show(AdminReservation $adminReservation): Response
    {
        return $this->render('admin_reservation/show.html.twig', [
            'admin_reservation' => $adminReservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AdminReservation $adminReservation, AdminReservationRepository $adminReservationRepository): Response
    {
        $form = $this->createForm(AdminReservationType::class, $adminReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminReservationRepository->add($adminReservation, true);

            return $this->redirectToRoute('app_admin_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_reservation/edit.html.twig', [
            'admin_reservation' => $adminReservation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, AdminReservation $adminReservation, AdminReservationRepository $adminReservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $adminReservation->getId(), $request->request->get('_token'))) {
            $adminReservationRepository->remove($adminReservation, true);
        }

        return $this->redirectToRoute('app_admin_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
