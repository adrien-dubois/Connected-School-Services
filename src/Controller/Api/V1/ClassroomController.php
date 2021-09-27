<?php

namespace App\Controller\Api\V1;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * 
 * @Route("/api/v1/classroom", name="api_v1_classroom_", requirements={"id"="\d+"})
 */
class ClassroomController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * Get the classroom list
     * @param ClassroomRepository $classroomRepository
     * @return Response
     */
    public function index(ClassroomRepository $classroomRepository): Response
    {
        $classroom = $classroomRepository->findAll();

        return $this->json($classroom, 200, [], [

            'groups' => 'classroom'
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * Get a classroom by its ID
     * 
     * @param integer $id
     * 
     * @param ClassroomRepository $classroomRepository
     * 
     * @return JsonResponse
     */
    public function show(int $id, ClassroomRepository $classroomRepository)
    {
        $classroom = $classroomRepository->find($id);
        if (!$classroom) {
            return $this->json([
                'error' => 'La classe' . $id . 'n\'existe pas'
            ],404);
        }

        return $this->json($classroom, 200, [], [
            'groups' => 'classroom'
        ]);
    }

    /**
     * Display classrooms order by teachers ID
     * 
     * @Route("/sortedbyteacher/{id}", name="sortedby_teacher", methods={"GET"})
     *
     * @param integer $id
     * @param ClassroomRepository $classroomRepository
     * @param TeacherRepository $teacherRepository
     * @return void
     */
    public function sortedByTeacher(int $id, ClassroomRepository $classroomRepository, TeacherRepository $teacherRepository)
    {

        $classroom = $classroomRepository->findByTeacher($id);

        return $this->json($classroom, 200, [], [
            'groups'=>'classroom'
        ]);
    }

    /**
     * Create a new classroom
     * @Route("/", name="add", methods={"POST"})
     * @IsGranted("ROLE_TEACHER")
     * 
     * @param Request $request
     * @param SerializerInterface $serializerInterface
     * @param ValidatorInterface $validatorInterface
     * @return void
     */
    public function add(Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validatorInterface)
    {
        $jsonData = $request->getContent();

        $classroom = $serializerInterface->deserialize($jsonData, Classroom::class, 'json');

        $errors = $validatorInterface->validate($classroom);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($classroom);
        $em->flush();

        return $this->json($classroom, 201);
    }

    /**
     * Update a classroom by its ID with PUT or PATCH method
     * 
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     * @IsGranted("ROLE_TEACHER")
     * 
     * @param integer $id
     * @param ClassroomRepository $classroomRepository
     * @param SerializerInterface $serializerInterface
     * @param Request $request
     * @return void
     */
    public function update(int $id, ClassroomRepository $classroomRepository, SerializerInterface $serializerInterface, Request $request)
    {
        $jsonData = $request->getContent();

        $classroom = $classroomRepository->find($id);

        if(!$classroom) {
            return $this->json(
                [
                    'errors' => [
                        'message' => 'La classe' . $id . 'n\'existe pas'
                    ]
                ],
                404
            );
        }

        $serializerInterface->deserialize($jsonData, Classroom::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $classroom]);

        $this->getDoctrine()->getManager()->flush();

        return $this->json([
            'message' => 'La classe ' . $classroom->getGrade() . '-' . $classroom->getLetter() . ' a bien été mise a jour' 
        ]);
    }

    /**
     * Delete a classroom
     *
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @IsGranted("ROLE_TEACHER")
     * @param integer $id
     * @param ClassroomRepository $classroomRepository
     * @return JsonResponse
     */
    public function delete (int $id, ClassroomRepository $classroomRepository)
    {
        $classroom = $classroomRepository->find($id);

        if (!$classroom) {
            return $this->json([
                'error' => 'La classe ' . $id . 'n\'existe pas'
            ], 404);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();

        return $this->json([
            'ok'=>'La classe a bien été supprimée'
        ], 200
    );
        
    }
}
