<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Repository\ReservationsRespository;
use App\Form\Reservations1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/res/contreoller')]
class ResContreollerController extends AbstractController
{
    #[Route('/', name: 'app_res_contreoller_index', methods: ['GET'])]
    public function index(ReservationsRespository $reservationsRespository): Response
    {
        return $this->render('res_contreoller/index.html.twig', [
            'reservations' => $reservationsRespository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_res_contreoller_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(Reservations1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_res_contreoller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('res_contreoller/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_res_contreoller_show', methods: ['GET'])]
    public function show(Reservations $reservation): Response
    {
        return $this->render('res_contreoller/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_res_contreoller_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reservations1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_res_contreoller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('res_contreoller/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_res_contreoller_delete', methods: ['POST'])]
    public function delete(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_res_contreoller_index', [], Response::HTTP_SEE_OTHER);
    }
}
