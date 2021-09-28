<?php

namespace App\Controller;

use App\Repository\DisciplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher", name="teacher_", requirements={"id"="\d+"})
 */
class TeacherController extends AbstractController
{
    /**
     * Display all discipline to order teachers
     *
     * @Route("/", name="home", methods={"GET"})
     * 
     * @return Response
     */
    public function index(DisciplineRepository $discipline): Response
    {
        return $this->render('teacher/teacher.html.twig', [
                'disciplines'=>$discipline->findAll()
        ]);
    }


}
