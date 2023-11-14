<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransportController extends AbstractController
{
    private $transportRepository;

    public function __construct(TransportRepository $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    #[Route('/transports', name: 'transports_index')]
    public function index(): Response
    {
        $transports = $this->transportRepository->findAll();

        return $this->render('transport/index.html.twig', [
            'transports' => $transports,
        ]);
    }

    #[Route('/transports/add', name: 'transports_add')]
    public function add(Request $request): Response
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transport);
            $entityManager->flush();

            return $this->redirectToRoute('transports_index');
        }

        return $this->render('transport/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/transports/edit/{id}', name: 'transports_edit')]
    public function edit($id, Request $request): Response
    {
        $transport = $this->transportRepository->find($id);
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transports_index');
        }

        return $this->render('transport/edit.html.twig', [
            'form' => $form->createView(),
            'transport' => $transport,
        ]);
    }

    #[Route('/transports/show/{id}', name: 'transports_show')]
    public function show($id): Response
    {
        $transport = $this->transportRepository->find($id);

        return $this->render('transport/show.html.twig', [
            'transport' => $transport,
        ]);
    }

    #[Route('/transports/delete/{id}', name: 'transports_delete')]
    public function delete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $transport = $entityManager->getRepository(Transport::class)->find($id);

        if ($transport) {
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transports_index');
    }
}

