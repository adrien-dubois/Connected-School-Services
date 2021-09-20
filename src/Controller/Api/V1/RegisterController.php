<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/register", name="api_v1_register_")
 */
class RegisterController extends AbstractController
{
    
    /**
     * Method for user registration
     * 
     * @Route("/", name="add", methods={"POST"})
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @param \Swift_Mailer $mailer
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface, \Swift_Mailer $mailer, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        
        // Define a default password, that will be change by the user
        $plainPassword = 'cssteamisthebest';

        $jsonData = $request->getContent();

        $user = $serializer->deserialize($jsonData, User::class, 'json');

        $errors = $validator->validate($user);
        
        
            // encode the plain password
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $plainPassword
                )
            );

            $user->setActivationToken(md5(uniqid()));

            if(count($errors) > 0 ){
                return $this->json($errors, 400);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            $message = (new \Swift_Message('Activation de votre compte'))
                    ->setFrom('admin@css.io')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'email/activation.html.twig',
                            ['token'=>$user->getActivationToken()]
                        ),
                        'text/html'
                    )
            ;
            $mailer->send($message);


            
        

        return $this->json($user, 201);
    }
}
