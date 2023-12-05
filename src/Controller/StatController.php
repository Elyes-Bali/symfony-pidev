<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class StatController extends AbstractController
{
    #[Route('/stats', name: 'app_statistics')]
    public function statistics(UserRepository $userRepository): Response
    {
        // Récupérer le nombre total d'utilisateurs depuis le repository
        $totalUsers = $userRepository->getTotalUsers();

        // Vous pouvez utiliser ces données pour générer un schéma ou simplement les afficher
        return $this->render('stat/index.html.twig', [
            'totalUsers' => $totalUsers,
        ]);
    }
}


