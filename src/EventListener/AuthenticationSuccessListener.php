<?php

namespace App\EventListener;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener {

    private $repository;

    // Construct the repo to get it into the method, neither the method wouldn't take it
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        // Get the datas after success response and get the User in UserInterface
        $data = $event->getData();
        $user = $event->getUser();
        // Take the username according the UserInterface
        $users = $user->getUserIdentifier();
        // Find the good user with the username/email
        $test = $this->repository->findOneBy(['email'=>$users]);
        // And get the datas we need
        $first = $test->getFirstname();
        $last = $test->getLastname();
        $role = $user->getRoles();
        $id = $test->getId();

        if($role == ["ROLE_USER"]){
            $class = $test->getClassroom();
            $letter = $class->getLetter();
            $grade = $class->getGrade();
            $classId = $class->getId();
        }
        else{
            $class = $test->getClassroom();
        }
        // Check and verify if $user is well part of UserInterface
        if(!$user instanceof UserInterface) {
            return;
        }
       
        // And then make the data array that will display in the body response of the connection with the JWT Token
        if($role == ["ROLE_USER"]){
        $data['data'] = array(
            'id' => $id,
            'firstname' => $first,
            'lastname' => $last,
            'roles' => $user->getRoles(),
                'classroom' => [
                    'id'=>$classId,
                    'letter'=>$letter,
                    'grade'=>$grade
                ]
            );
        }
        else{
            $data['data'] = array(
                'firstname' => $first,
                'lastname' => $last,
                'roles' => $user->getRoles(),
                'classroom' => $class
            );
        }
        // Set it in the event
        $event->setData($data);
    }
}