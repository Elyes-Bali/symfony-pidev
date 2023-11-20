<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Form\Circuit1Type;
use App\Repository\CircuitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/circuit')]
class CircuitController extends AbstractController
{
    #[Route('/', name: 'app_circuit_index', methods: ['GET'])]
    public function index(CircuitRepository $circuitRepository): Response
    {
        return $this->render('circuit/index.html.twig', [
            'circuits' => $circuitRepository->findAll(),
        ]);
    }

    #[Route('/client', name: 'client', methods: ['GET'])]
    public function client(CircuitRepository $circuitRepository): Response
    {
        return $this->render('circuit/clientCircuit.html.twig', [
            'circuits' => $circuitRepository->findAll(),
        ]);
    }
    #[Route('/front', name:'home')]
    public function front(): Response
    {
        return $this->render('/classe/front.html.twig');
    }


    #[Route('/new', name: 'app_circuit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $circuit = new Circuit();
        $form = $this->createForm(Circuit1Type::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($circuit);
            $entityManager->flush();

            return $this->redirectToRoute('app_circuit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('circuit/new.html.twig', [
            'circuit' => $circuit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_circuit_show', methods: ['GET'])]
    public function show(Circuit $circuit): Response
    {
        return $this->render('circuit/show.html.twig', [
            'circuit' => $circuit,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_circuit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Circuit $circuit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Circuit1Type::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_circuit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('circuit/edit.html.twig', [
            'circuit' => $circuit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_circuit_delete', methods: ['POST'])]
    public function delete(Request $request, Circuit $circuit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($circuit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_circuit_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'client_show', methods: ['GET'])]
    public function showing(Circuit $circuit): Response
    {
        return $this->render('circuit/clientdetail.html.twig', [
            'circuit' => $circuit,
        ]);
    }
}
