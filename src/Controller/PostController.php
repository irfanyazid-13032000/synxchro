<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Post;
use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;
use App\Form\PostFormType;


#[Route('/post', name: 'post.')]
class PostController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager)
    {
        $posts = $entityManager->getRepository(Post::class)->findAllWithGenre(); // Menggunakan custom repository method untuk mengambil post dengan genre
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager, Request $request)
    {

        $post = new Post();

      
        $form = $this->createForm(PostFormType::class, $post, [
            'genres' => $entityManager->getRepository(Genre::class)->findAll(), // Meneruskan daftar genre
        ]);

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


    #[Route('/update/{id}', name: 'update')]
    public function update(EntityManagerInterface $entityManager, Post $post,Request $request)
    {
        $form = $this->createForm(PostFormType::class, $post, [
            'genres' => $entityManager->getRepository(Genre::class)->findAll(), // Meneruskan daftar genre
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            return $this->redirectToRoute('post.index');
        }


        return $this->render('post/create.html.twig',['form'=>$form]);
    }




    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, Post $post,$id)
    {
        $entityManager->remove($post);
        $entityManager->flush();
        return $this->redirectToRoute('post.index');
    }



   
}
