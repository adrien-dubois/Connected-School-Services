<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    
    /**
     * Display homepage
     * 
     * @Route("/", name="home")
     * @IsGranted("ROLE_ADMIN")
     *
     * @return void
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

}