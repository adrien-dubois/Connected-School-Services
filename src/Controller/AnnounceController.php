<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Form\AnnounceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/announce", name="announce_")
 */
class AnnounceController extends AbstractController
{
    /**
     * @Route("/add", name ="add")
     *
     * @return Response
     */
    public function add(Request $request): Response
    {
        $announce = new Announce();

        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($announce);
            $em->flush();

            $this->addFlash(
                'success',
                'L\'annonce a bien été postée'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('announce/announce.html.twig',[
            'formView' => $form->createView()
        ] );
    }
}
