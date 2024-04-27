<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;


#[Route('/post', name: 'post.')]
class PostController extends AbstractController
{

    // http://127.0.0.1:8000/post
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager)
    {
        $posts = $entityManager->getRepository(Post::class)->findAll();
        dump($posts);
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    // http://127.0.0.1:8000/post/create
    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager)
    {

        $post = new Post();

        $post->setTitle('illit lucky girl syndrome enak juga loh lagunya!!!');

        $entityManager->persist($post);

        $entityManager->flush();

        return new Response('post was created !!!');
    }


    // http://127.0.0.1:8000/post/show/4
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
