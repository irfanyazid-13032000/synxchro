<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;
use App\Form\PostFormType;


#[Route('/post', name: 'post.')]
class PostController extends AbstractController
{

    // http://127.0.0.1:8000/post
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager)
    {
        $posts = $entityManager->getRepository(Post::class)->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager, Request $request)
    {

        $post = new Post();


        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);

            $entityManager->flush();

            return $this->redirectToRoute('post.index');
        }
        return $this->render('post/create.html.twig',['form'=>$form]);

    }


    #[Route('/show/{id}', name: 'show')]
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig',[
            'post'=>$post
        ]);
    }


    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, Post $post,$id)
    {
        $entityManager->remove($post);
        $entityManager->flush();
        return $this->redirectToRoute('post.index');
    }



   
}
