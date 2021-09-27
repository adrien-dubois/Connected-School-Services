<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/student", name="student_")
 * @IsGranted("ROLE_ADMIN")
 */
class StudentController extends AbstractController
{
    /**
     * Display all classrooms
     * 
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function index(ClassroomRepository $classroomRepository): Response
    {
        return $this->render('student/index.html.twig', [
            'classrooms'=>$classroomRepository->findAll()
        ]);
    }

    public function studentList(Classroom $classroom)

}
