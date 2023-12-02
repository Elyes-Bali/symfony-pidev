<?php

// src/Controller/QrCodeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\QrCode;

#[Route('/qr')]
class QrCodeController extends AbstractController
{
    #[Route('/generate', name: 'generate_qr_code')]
    public function generateQrCode(): Response
    {
        // Generate a simple QR code
        $qrCode = new QrCode('Hello, QR Code!');

        // Output the QR code as an image
        $response = new Response($qrCode->writeString(), Response::HTTP_OK, [
            'Content-Type' => $qrCode->getContentType(),
        ]);

        return $response;
    }
}
