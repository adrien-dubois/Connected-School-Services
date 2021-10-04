<?php

namespace App\Controller;

use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/classroom", name="classroom_", requirements={"id"="\d+"})
 */
class ClassroomController extends AbstractController
{
    /**
     * Display classrooms' list
     * 
     * @Route("/", name="home", methods={"GET"})
     *
     * @return Response
     */
    public function index(ClassroomRepository $classroomRepository): Response
    {
        return $this->render('classroom/classroom.html.twig', [
            "classrooms"=>$classroomRepository->findAll()
        ]);
    }
}
