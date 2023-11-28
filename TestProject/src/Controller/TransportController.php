<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Twilio\Rest\Client;

use Endroid\QrCodeBundle\Response\QrCodeResponse;

use Endroid\QrCode\Builder\BuilderInterface;
class TransportController extends AbstractController
{

    private $customQrCodeBuilder;
    

    public function __construct(BuilderInterface $customQrCodeBuilder, TransportRepository $transportRepository)
    {
        $this->customQrCodeBuilder = $customQrCodeBuilder;
        
    }
    #[Route('/transports', name: 'transports_index')]
    public function index(TransportRepository $transportRepository): Response
    {
        $transports = $transportRepository->findAll();

        return $this->render('transport/index.html.twig', [
            'transports' => $transports,
        ]);
    }

    #[Route('/transports/add', name: 'transports_add')]
    public function add(Request $request, Client $twilioClient): Response
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transport);
            $entityManager->flush();

            $toNumber = '+21629802364';
            $fromNumber = '+13317033061';
            $message = $twilioClient->messages->create(
                $toNumber,
                [
                    'from' => $fromNumber,
                    'body' => 'Un moyen de transport de type : ' .$transport->getType().
                    ' Son date de depart est : ' .$transport->getDd()->format('Y-m-d H:i').
                    ' Son date d arrivee est : ' .$transport->getDa()->format('Y-m-d H:i').
                    ' Avec une capacite de : ' .$transport->getCap().
                    ' Et un prix de : ' .$transport->getPrix().
                    ' a ete ajoute avec succes.'
                ]
            );

            return $this->redirectToRoute('transports_index');
        }

        return $this->render('transport/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/transports/edit/{id}', name: 'transports_edit')]
    public function edit($id, Request $request,TransportRepository $transportRepository): Response
    {
        $transport = $transportRepository->find($id);
        $form = $this->createForm(TransportType::class, $transport);
        $form->add('captcha', CaptchaType::class, [
            'label' => 'Captcha',
        ]);
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
    public function show($id,TransportRepository $transportRepository): Response
    {
        $transport = $transportRepository->find($id);
        
        return $this->render('transport/show.html.twig', [
            'transport' => $transport,
            
        ]);
    }
    #[Route('/genere/{id}', name: 'transport_show_qr')] 
    public function generateCustomQrCode(Request $request,$id,TransportRepository $transportRepository): Response
    {
        $transport = $transportRepository->find($id);// Assuming the ID is passed in the URL parameter
        $data = [
            'id' => $transport->getId(),
            'cap' => $transport->getCap(),
            'type' => $transport->getType(),
            'dd' => $transport->getDd()->format('Y-m-d H:i:s'),
            'da' => $transport->getDa()->format('Y-m-d H:i:s'),
            'prix' => $transport->getPrix(),
        ];
        

        if (!$transport) {
            throw $this->createNotFoundException('Transport not found');
        }

        $result = $this->customQrCodeBuilder
            ->data(json_encode($data)) // Encode transport data into the QR code
            ->size(400)
            ->margin(20)
            ->build();

        $response = new QrCodeResponse($result);

        return $response;
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

    #[Route('/transportsFront', name: 'transports_index_front')]
    public function indexFront(TransportRepository $transportRepository): Response
    {
        $transports = $transportRepository->findAll();

        return $this->render('transport/viewFront.html.twig', [
            'transports' => $transports,
        ]);
    }
    #[Route('/transports/statistics', name: 'transports_statistics')]
public function statistics(TransportRepository $repo): Response
{
    $totalTransports = $repo->countAll(); // Méthode à ajouter dans votre TransportRepository
    $transportsUnder300 = $repo->countByPriceUnder300();
    $transportsAbove300 = $repo->countByPriceAbove300();

    $percentageUnder300 = $totalTransports > 0 ? ($transportsUnder300 / $totalTransports) * 100 : 0;
    $percentageAbove300 = $totalTransports > 0 ? ($transportsAbove300 / $totalTransports) * 100 : 0;

    return $this->render('transport/statistics.html.twig', [
        'totalTransports' => $totalTransports,
        'transportsUnder300' => $transportsUnder300,
        'transportsAbove300' => $transportsAbove300,
        'percentageUnder300' => $percentageUnder300,
        'percentageAbove300' => $percentageAbove300,
    ]);
}

#[Route('/export/excel', name: 'export_excel')]
public function exportExcel(TransportRepository $transportRepository): Response
{
   
    $transports = $transportRepository->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

   
    $sheet->setCellValue('A1', 'Type');
    $sheet->setCellValue('B1', 'Capacité');
    $sheet->setCellValue('C1', 'Date de Départ');
    $sheet->setCellValue('D1', 'Date d\'Arrivée');
    $sheet->setCellValue('E1', 'Prix');

   
    $row = 2;
    foreach ($transports as $transport) {
        $sheet->setCellValue('A' . $row, $transport->getType());
        $sheet->setCellValue('B' . $row, $transport->getCap());
        $sheet->setCellValue('C' . $row, $transport->getDd()->format('Y-m-d H:i'));
        $sheet->setCellValue('D' . $row, $transport->getDa()->format('Y-m-d H:i'));
        $sheet->setCellValue('E' . $row, $transport->getPrix());
        $row++;
    }

    
    $response = new Response();

    
    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->headers->set('Content-Disposition', 'attachment;filename="export.xlsx"');

    $writer = new Xlsx($spreadsheet);
ob_start(); 
$writer->save('php://output');
$excelContent = ob_get_contents(); 
ob_end_clean(); 

$response->setContent($excelContent);

return $response;
}


#[Route('/transports/stat/Capacite', name: 'stat_cap')]
public function statCapacite(TransportRepository $repo): Response
{
    return $this->render('transport/stat.html.twig', [
        'transports' => $repo->findAll(),
    ]);
}

#[Route('/TriType', name: 'app_tri_type')]
public function TriType(TransportRepository $repo){
    $transport=$repo->orderByType();
    return $this->render("transport/index.html.twig", array("transports" => $transport));
}

#[Route('/TriCapacite', name: 'app_tri_capacite')]
public function TriCapacite(TransportRepository $repo){
    $transport=$repo->orderByCapacite();
    return $this->render("transport/index.html.twig", array("transports" => $transport));
}

#[Route('/TriPrix', name: 'app_tri_prix')]
public function TriPrix(TransportRepository $repo){
    $transport=$repo->orderByPrix();
    return $this->render("transport/index.html.twig", array("transports" => $transport));
}

#[Route('/TriDD', name: 'app_tri_dd')]
public function TriDD(TransportRepository $repo){
    $transport=$repo->orderByDD();
    return $this->render("transport/index.html.twig", array("transports" => $transport));
}

#[Route('/transports/generate-qr/{id}', name: 'generate_qr_code')]
public function generateQrCode($id): Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);
        if (!$transport) {
            throw $this->createNotFoundException('Transport not found for id ' . $id);
        }
        $data = [
            'id' => $transport->getId(),
            'cap' => $transport->getCap(),
            'type' => $transport->getType(),
            'dd' => $transport->getDd()->format('Y-m-d H:i:s'),
            'da' => $transport->getDa()->format('Y-m-d H:i:s'),
            'prix' => $transport->getPrix(),
        ];
        $jsonData = json_encode($data);

        // Create the renderer for the QR code
        $renderer = new ImageRenderer(
            new ImagickImageBackEnd(), // Use Imagick for rendering
            new Fill(255, 255, 255),    // Background color
            new Fill(0, 0, 0)           // Foreground color
        );
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($jsonData);

        // Return a response with the QR code
        return $this->render('transport/qr_code.html.twig', [
            'transport' => $transport,
            'qrCode' => $qrCode,
        ]);

    }


}
