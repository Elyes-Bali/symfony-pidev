<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{

    #[Route('/statistics', name: 'app_post_statistics', methods: ['GET'])]
    public function postStatistics(PostRepository $postRepository): Response
    {

        $postStatistics = $postRepository->getAllPostStatistics();

        return $this->render('postfront/stat.html.twig', [
            'postStatistics' => $postStatistics,
        ]);
    }
}
