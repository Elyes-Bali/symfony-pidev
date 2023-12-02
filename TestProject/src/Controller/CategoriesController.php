<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRespository;
use App\Form\CategoriesType;
use BaconQrCode\Encoder\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Writer\PngWriter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/asb')]
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('aminfsm2001@gmail.com')
            ->to('dhouhazouaghi8@gmail.com')
            ->subject('à propos des catégories')
            ->text('une nouvelle catégorie d\'evenement a  été ajoutée ');
        // ->html('<p>Contenu du message en HTML</p>');
    
        try {
            $mailer->send($email);
            // Envoyé avec succès, vous pouvez renvoyer une réponse de succès
            return new Response('Email envoyé avec succès!');
        } catch (\Exception $e) {
            // En cas d'échec, renvoyez un message d'erreur ou utilisez un gestionnaire d'erreurs
            return new Response('Erreur lors de l\'envoi de l\'email : ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/', name: 'app_categories_index', methods: ['GET'])]
    public function index(CategoriesRespository $categoriesRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }
    
    #[Route('/Front', name: 'app_categories_indexFront', methods: ['GET'])]
    public function indexF(CategoriesRespository $categoriesRepository): Response
    {
        return $this->render('categories/indexFront.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categories_show', methods: ['GET'])]
    public function show(Categories $category): Response
    {
        return $this->render('categories/show.html.twig', [
            'category' => $category,
        ]);
    }
   

    #[Route('/{id}/edit', name: 'app_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categories $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categories $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }

 
// #[Route('/search/categories', name: 'search_categories', methods: ['POST'])]
// public function searchMatricule(Request $request): JsonResponse
// {
//     $nom = $request->request->get('nom');

//     $repository = $this->getDoctrine()->getRepository(Categories::class);
//     $results = $repository->findBy(['nom' => $nom]);

//     $responseArray = array();
//     foreach ($results as $result) {
//         $responseArray[] = array(
//             'id' => $result->getId(),
//             'nom' => $result->getNom(),
//             'description' => $result->getDescription(),
        
        
//         );
//     }

//     return new JsonResponse($responseArray);
// }

// #[Route('/generate-qr/{id}', name: 'app_badge_generate_qr', methods: ['GET'])]
//     public function generateQrCodeForBadge($id, CategoriesRespository $badgeRepository): Response
//     {
//         $badge = $badgeRepository->find($id);

//         // Générer le contenu du QR Code (utilisez toutes les informations du client)
//         $qrContent = sprintf(
//             "Commentaire: %s\nDate du badge: %s\n",
//     $badge->getId(),
//     $badge->getNom()
   
//         );

//         // Créer une instance de QrCode
//         $qrCode = new QrCode($qrContent);

//         // Créer une instance de PngWriter pour générer le résultat sous forme d'image PNG
//         $writer = new PngWriter();
//         $result = $writer->write($qrCode);

//         // Créer une réponse avec le résultat du QR Code
//         $response = new Response($result->getString(), Response::HTTP_OK, [
//             'Content-Type' => $result->getMimeType(),
//         ]);

//         return $response;
//     }

    // #[Route('/search', name: 'app_categories_search', methods: ['POST'])]
    // public function search(Request $request, CategoriesRespository $categoriesRepository): Response
    // {
    //     $criteria = [
    //         'id' => $request->request->get('id'),
    //         'nom' => $request->request->get('nom'),
    //         'description' => $request->request->get('description'),
    //     ];

    //     $categories = $categoriesRepository->searchByCriteria($criteria);

    //     return $this->render('categories/index.html.twig', [
    //         'categories' => $categories,
    //     ]);
    // }
 
}

