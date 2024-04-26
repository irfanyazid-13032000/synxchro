<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/halo/{name}', name: 'halo')]
    public function halo(Request $request)
    {
        return $this->render('home/index.html.twig',['name'=>$request->get('name')]);
    }
}
