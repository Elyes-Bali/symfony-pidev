<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Form\HebergementType;
use App\Repository\HebergementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options; 



#[Route('/hebergement')]
class HebergementController extends AbstractController
{

    #[Route('/exportPDF/{id}', name: 'exportPDF')]
    public function Print(HebergementRepository $repo, $id):Response
    {        
        $pdfoptions=new Options();

        $pdfoptions->set('defaultFont','Arial');
        $dompdf= new Dompdf($pdfoptions);
        
        $hebergement = $repo->find($id);

        $html=$this->renderView('hebergement/pdfExport.html.twig',[
            'hebergement' => $hebergement,
        ]);

        $headerHtml = '<h1 style="text-align: center; color:#FFFF00;">Bienvenue</h1>';
        $html= $headerHtml . $html;

        //$html = '<div>' . $html . '</div>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A6','portrait');

        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachement; filename="Hebergement.pdf"',
        ]);

    }

    #[Route('/TriType', name: 'app_tri_type')]
    public function TriType(HebergementRepository $repo){
        $hebergement=$repo->orderByType();
        return $this->render("hebergement/index.html.twig", array("hebergements" => $hebergement));
    }

    #[Route('/TriAdresse', name: 'app_tri_adresse')]
    public function TriAdresse(HebergementRepository $repo){
        $hebergement=$repo->orderByAdresse();
        return $this->render("hebergement/index.html.twig", array("hebergements" => $hebergement));
    }

    #[Route('/TriCapacite', name: 'app_tri_capacite')]
    public function TriCapacite(HebergementRepository $repo){
        $hebergement=$repo->orderByCapacite();
        return $this->render("hebergement/index.html.twig", array("hebergements" => $hebergement));
    }

    #[Route('/TriPrix', name: 'app_tri_prix')]
    public function TriPrix(HebergementRepository $repo){
        $hebergement=$repo->orderByPrix();
        return $this->render("hebergement/index.html.twig", array("hebergements" => $hebergement));
    }


    #[Route('/', name: 'app_hebergement_index', methods: ['GET'])]
    public function index(HebergementRepository $hebergementRepository): Response
    {
        return $this->render('hebergement/index.html.twig', [
            'hebergements' => $hebergementRepository->findAll(),
        ]);
    }

    #[Route('/front', name: 'app_hebergement_index_front', methods: ['GET'])]
    public function indexFront(HebergementRepository $hebergementRepository,
        PaginatorInterface $paginator,
        Request $request
        ): Response
    {
        $data=$hebergementRepository->findAll();

        $hebergements=$paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );

        return $this->render('hebergement/viewFront.html.twig', [
            'hebergements' => $hebergements,
        ]);
    }

    #[Route('/new', name: 'app_hebergement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Client $twilioClient): Response
    {
        $hebergement = new Hebergement();
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hebergement);
            $entityManager->flush();
            

            $toNumber = '+21622711171';
            $fromNumber = '+12293745487';
            $message = $twilioClient->messages->create(
                $toNumber,
                [
                    'from' => $fromNumber,
                    'body' => 'Une hebergement a ete ajoutee avec succes.',
                ]
            );

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hebergement/new.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hebergement_show', methods: ['GET'])]
    public function show(Hebergement $hebergement): Response
    {
        return $this->render('hebergement/show.html.twig', [
            'hebergement' => $hebergement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hebergement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hebergement $hebergement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hebergement/edit.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hebergement_delete', methods: ['POST'])]
    public function delete(Request $request, Hebergement $hebergement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hebergement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hebergement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
    }

    

    
}
