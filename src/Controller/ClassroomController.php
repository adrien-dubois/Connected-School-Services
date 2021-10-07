<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * Display classrooms by grade
     * 
     * @Route("/{id}/grade_list", name="list")
     *
     * @param integer $id
     * @param ClassroomRepository $repository
     * @return void
     */
    public function classList(int $id, ClassroomRepository $repository)
    {
        $list = $repository->findBy(['grade'=>$id], ['letter'=>'ASC']);

        return $this->render('classroom/classlist.html.twig',[
            "class"=>$list
        ]);
    }

    /**
     * Create a new classroom
     * 
     * @Route("/add", name="add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $class = new Classroom();

        $form = $this->createForm(ClassroomType::class, $class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid){

            $em = $this->getDoctrine()->getManager();
            $em->persist($class);
            $em->flush();

            $this->addFlash(
                'success',
                'La nouvelle classe a bien été ajoutée'
            );

            return $this->redirectToRoute('classroom_home');
        }

        return $this->render('classroom/add.html.twig',[
            'formView'=>$form->createView()
        ]);
    }
}
