<?php

namespace App\Controller\Api\V1;

use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeAnnounceController extends AbstractController
{
    /**
     * @Route("/api/v1/homeannounce", name="api_v1_home_announce", methods={"GET"})
     */
    public function index(AnnounceRepository $announceRepository): Response
    {
        $announces = $announceRepository->findAll();

        return $this->json($announces, 200, [],[
            'groups' => 'announce'
        ]);
    }
}
