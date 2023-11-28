<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(Request $request, PostRepository $postRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $postRepository->findAll(),  // Replace with your custom query or repository method
            $request->query->getInt('page', 1), // page number
            4 // items per page
        );

        return $this->render('postfront/postaffichage.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['image']->getData();

            if ($uploadedFile) {
                $newFilename = uniqid().'.'.$uploadedFile->guessExtension();


                $uploadedFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );


                $post->setImage($newFilename);
            }


            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('postfront/addpost.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_post_show', methods: ['GET', 'POST'])]
    public function detailsAction(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {

        $post = $this->getDoctrine()->getRepository(Post::class)->findWithComments($post->getId());


        $commentaire = new Commentaire();
        $commentForm = $this->createForm(CommentaireType::class, $commentaire);


        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $commentaire->setPost($post);
            $commentaire->setDatenow((new \DateTime())->format('Y-m-d H:i:s'));


            $entityManager->persist($commentaire);
            $entityManager->flush();


            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }


        return $this->render('postfront/details.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_post_edit')]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Post $post, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }





}
