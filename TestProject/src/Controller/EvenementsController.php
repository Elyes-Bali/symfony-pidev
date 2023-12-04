<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EvenementsType;
use App\Repository\EvenementsRespository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/evenements')]
class EvenementsController extends AbstractController
{
    #[Route('/', name: 'app_evenements_index', methods: ['GET'])]
    public function index(EvenementsRespository $evenementsRespository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $evenementsRespository->findAll();
    
        $evenements = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );
    
        return $this->render('evenements/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }


    #[Route('/evenementsFront', name: 'evenements_index_front')]
    public function indexFront(EvenementsRespository $evenementsRepository): Response
    {
        $evenements = $evenementsRepository->findAll();
    
        return $this->render('evenements/viewFront.html.twig', [
            'evenements' => $evenements,
        ]);
    }
    


    #[Route('/new', name: 'app_evenements_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, FlasherInterface $flasher): Response
{
    $evenement = new Evenements();
    $form = $this->createForm(EvenementsType::class, $evenement);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($evenement);
        $entityManager->flush();

        // Add a flash message
        $flasher->addSuccess('Evenement ajouté avec succès!');

        return $this->redirectToRoute('app_evenements_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('evenements/new.html.twig', [
        'evenement' => $evenement,
        'form' => $form,
    ]);
}
   #[Route('/{id}', name: 'app_evenements_show', methods: ['GET'])]
public function show(Evenements $evenement): Response
{
    return $this->render('evenements/show.html.twig', [
        'evenement' => $evenement,
    ]);
}

    #[Route('/{id}/edit', name: 'app_evenements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenements $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementsType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenements/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenements_delete', methods: ['POST'])]
    public function delete(Request $request, Evenements $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenements_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/asb')]
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('dhouhazouaghi8@gmail.com')
            ->to('nasriamin300@gmail.com')
            ->subject('amin')
            ->text('amin');
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
    
        #[Route('/evenements/stat/{id}', name: 'app_evenements_stat', methods: ['GET'])]
        public function chart(EvenementsRespository $evenementsRespository, string $id): Response
        {
            // Cast the $id parameter to int
            $id = (int) $id;
    
            // Retrieve and process data using the $id parameter and $evenementsRespository
            $categories = $evenementsRespository->getCategoriesCount($id);
    
            // Prepare data for the chart
            $data = [['Catégorie', 'Nombre d\'événements']];
            foreach ($categories as $category) {
                $data[] = [$category['nom'], (int) $category['total']];
            }
    
            // Render the chart template with the prepared data
            return $this->render('evenements/stat.html.twig', [
                'data' => $data,
            ]);
        }
  
      
    }


  
