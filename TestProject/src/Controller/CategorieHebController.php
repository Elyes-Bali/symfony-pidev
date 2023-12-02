<?php

namespace App\Controller;

use App\Entity\CategorieHeb;
use App\Form\CategorieHebType;
use App\Repository\CategorieHebRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie/heb')]
class CategorieHebController extends AbstractController
{
    #[Route('/', name: 'app_categorie_heb_index', methods: ['GET'])]
    public function index(CategorieHebRepository $categorieHebRepository): Response
    {
        return $this->render('categorie_heb/index.html.twig', [
            'categorie_hebs' => $categorieHebRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorie_heb_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieHeb = new CategorieHeb();
        $form = $this->createForm(CategorieHebType::class, $categorieHeb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieHeb);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_heb_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_heb/new.html.twig', [
            'categorie_heb' => $categorieHeb,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_heb_show', methods: ['GET'])]
    public function show(CategorieHeb $categorieHeb): Response
    {
        return $this->render('categorie_heb/show.html.twig', [
            'categorie_heb' => $categorieHeb,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_heb_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieHeb $categorieHeb, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieHebType::class, $categorieHeb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_heb_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_heb/edit.html.twig', [
            'categorie_heb' => $categorieHeb,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_heb_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieHeb $categorieHeb, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieHeb->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorieHeb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_heb_index', [], Response::HTTP_SEE_OTHER);
    }
}
