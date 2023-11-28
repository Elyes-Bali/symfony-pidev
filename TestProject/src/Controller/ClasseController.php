<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/test')]
class ClasseController extends AbstractController
{
    #[Route('/classe', name: 'app_classe')]
    public function index(): Response
    {
        return $this->render('classe/index.html.twig', [
            'controller_name' => 'ClasseController',
        ]);
    }

    #[Route('/list')]
    function list(){
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            return $this-> render('classe/list.html.twig',
        ['auth'=>$authors]);
    }

    #[Route('/details/{i}', name:'DD')]
    function AuthorDetails ($i){
        $authors = array(
            array('id' => 1, 'picture' => '/images/az.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('/classe/details.html.twig',['ii'=>$i, 'aa'=>$authors]);
    }

    #[Route('/home', name:'home')]
    public function Home(): Response
    {
        return $this->render('/classe/front.html.twig');
    }

    #[Route('/dashboard', name:'dash')]
    public function Dashboard(): Response
    {
        return $this->render('/dashboard/dash.html.twig');
    }

    #[Route('/login', name:'login')]
    public function Login(): Response
    {
        return $this->render('/User/login.html.twig');
    }

    #[Route('/register', name:'register')]
    public function Register(): Response
    {
        return $this->render('/User/register.html.twig');
    }
}
