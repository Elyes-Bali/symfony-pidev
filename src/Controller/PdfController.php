<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'generate_pdf')]
   
    public function generatePdf(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
    
        // Configuration de Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
    
        // Récupération du contenu du template HTML
        $html = $this->renderView('backend/Pdf.html.twig', [
            'users' => $users // Correction du nom de variable
        ]);
    
        // Génération du PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Envoi du PDF en réponse HTTP
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="liste_users.pdf"');
    
        return $response;
    }
}
