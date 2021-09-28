<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\DisciplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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


    /**
     * Display teacher list from discipline
     * 
     * @Route("/{id}/discipline", name="discipline", methods={"GET"})
     *
     * @param Discipline $discipline
     * @return void
     */
    public function teacherList(Discipline $discipline)
    {
        return $this->render('teacher/teacher-list.html.twig',[
            'matiere'=>$discipline
        ]);
    }

    /**
     * Show a teacher by its ID
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @param Teacher $teacher
     * @return void
     */
    public function show(Teacher $teacher)
    {
        return $this->render('teacher/show.html.twig',[
            'user'=>$teacher
        ]);
    }

    /**
     * Register a new teacher
     * 
     * @Route("/add", name="add", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     * @param \Swift_Mailer $mailer
     * @return void
     */
    public function add(Request $request, UserPasswordHasherInterface $hasher, \Swift_Mailer $mailer)
    {
        $teacher = new Teacher();

        $plainPassword = 'cssteamisthebest';
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $teacher->setPassword(
                $hasher->hashPassword(
                    $teacher,
                    $plainPassword
                )
            );

            $teacher->setActivationToken(md5(uniqid()));

            $em=$this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();

            $message = (new \Swift_Message('Activation de votre compte'))
                    ->setFrom('admin@css.io')
                    ->setTo($teacher->getEmail())
                    ->setBody(
                        $this->renderView(
                            'email/activation-teacher.html.twig',
                            ['token'=>$teacher->getActivationToken()]
                        ),
                        'text.html'
                    );
                    $mailer->send($message);

                    $this->addFlash(
                        'success',
                        'Nouveau professeur enregistré avec succès'
                    );
                return $this->redirectToRoute('teacher_home');
        }

        return $this->render('teacher/register.html.twig',[
            'formView'=>$form->createView()
        ]);
    }

}
