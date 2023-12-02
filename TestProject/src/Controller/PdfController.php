<?php

// src/Controller/PdfController.php

namespace App\Controller;
use App\Entity\Evenements;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class PdfController extends AbstractController
{
    /**
     * @Route("/generate-pdf/{id}", name="generate_pdf")
     */
    public function generatePdf($id)
    {
        // Récupérez les données de l'événement en fonction de l'id
        $evenement = $this->getDoctrine()->getRepository(Evenements::class)->find($id);

        // Vérifiez si l'événement existe
        if (!$evenement) {
            throw $this->createNotFoundException('Event not found');
        }

        // Configurez dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Créez une instance de dompdf
        $dompdf = new Dompdf($options);

        // Ajoutez une page
        $dompdf->loadHtml($this->renderView('pdf/evenements_pdf.html.twig', ['evenement' => $evenement]));
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF (le contenu HTML est rendu au format PDF)
        $dompdf->render();

        // Renvoyez la réponse avec le PDF en tant que contenu
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="evenement.pdf"',
        ]);
    }
}
