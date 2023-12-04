<?php

namespace App\Controller;

use App\Repository\EvenementsRespository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'chart')]
    public function index(EvenementsRespository $evenementsRepository): Response
    {
        $eventStatistics = $evenementsRepository->countByCategorie();
    
        return $this->render('chart/index.html.twig', [
            'eventStatistics' => $eventStatistics,
        ]);
    }
}