<?php

namespace App\Controller\Api\V1;

use App\Entity\Announce;
use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/announce", name="api_v1_announce_", requirements={"id"="\d+"})
 */
class AnnounceController extends AbstractController
{
    /**
     * Endpoint for announce listing
     * 
     * @Route("/", name="index", methods={"GET"})
     *
     * @return Response
     */
    public function index(AnnounceRepository $announceRepository): Response
    {
        // We get the announces in DB and return it in Json
        $announce = $announceRepository->findAll();

        // This entry to the serializer will transform objects into Json, by searching only properties tagged by the "groups" name
        return $this->json($announce, 200, [], [
            'groups' => 'announce'
        ]);
    }

    /**
     *  Return informations of an announce with its ID
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @param integer $id
     * @param AnnounceRepository $announceRepository
     * @return void
     */
    public function show(int $id, AnnounceRepository $announceRepository)
    {
        // We get an announce by its ID
        $announce = $announceRepository->find($id);

        // If the announce does not exists, we display 404
        if(!$announce){
            return $this->json([
                'error' => 'L\'annonce numéro ' . $id . ' n\'existe pas'
            ], 404
            );
        }

        // We return the result with Json format
        return $this->json($announce, 200, [], [
            'groups' => 'announce'
        ]);
    }

    /**
     * Can create a new announce
     * 
     * @Route("/", name="add", methods={"POST"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        // we take back the JSON
        $jsonData = $request->getContent();

        // We transform the json in object
        // First argument : datas to deserialize
        // Second : The type of object we want 
        // Last : Start type
        $announce = $serializer->deserialize($jsonData, Announce::class, 'json');

        // We validate the datas stucked in $announce on criterias of annotations' Entity @assert
        $errors = $validator->validate($announce);

        // If the errors array is not empty, we return an error code 400 that is a Bad Request
        if(count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($announce);
        $em->flush();

        return $this->json($announce, 201);
    }

        /**
     * Can edit an existing announce by its ID
     * 
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     *
     * @return JsonResponse
     */
    public function edit(int $id, AnnounceRepository $announceRepository, Request $request, SerializerInterface $serializer)
    {
        $jsonData = $request->getContent();
        
        $announce = $announceRepository->find($id);
        if(!$announce){
            return $this->json([
                'errors' => ['message'=>'L\'annonce numéro' .$id . 'n\'existe pas']
            ], 404
            );
        }

        $serializer->deserialize($jsonData, Announce::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE=>$announce]);

        $this->getDoctrine()->getManager()->flush();

        return $this->json(["message"=>"L'annonce a bien été modifiée"], 200, [], [
            'groups' => 'announce'
        ]);
    }

    /**
     * Delete an existing announce by its id
     * 
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @param integer $id
     * @param AnnounceRepository $announceRepository
     * @return void
     */
    public function delete(int $id, AnnounceRepository $announceRepository)
    {
        $announce = $announceRepository->find($id);
        if(!$announce){
            return $this->json([
                'error' => 'Cette annonce n\'existe pas'
            ],404
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($announce);
        $em->flush();

        return $this->json([
            'ok'=>'L\'annonce a bien été supprimée'
        ], 200
        );
    }
}
