<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
     public function showHome()
        {
         return $this->render('home/index.html.twig', [
         ]);
        }

 }