<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/lesson", name="api_v1_lesson_", requirements={"id"="\d+"})
 */
class LessonController extends AbstractController
{
    /**
     * Get the lessons list
     * 
     * @Route("/", name="index", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/V1/LessonController.php',
        ]);
    }
}
