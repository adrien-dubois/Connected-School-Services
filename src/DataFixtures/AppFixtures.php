<?php

namespace App\DataFixtures;

use App\Entity\Announce;
use App\Entity\Category;
use App\Entity\Classroom;
use App\Entity\Day;
use App\Entity\Discipline;
use App\Entity\Lesson;
use App\Entity\Note;
use App\Entity\Planning;
use App\Entity\Teacher;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
           // on crée 4 auteurs avec email,noms, prénoms, adresse, numero de tel et image "aléatoires" en français
           $userList = Array();
           print 'creation des élèves ';
           for ($i = 0; $i < 15; $i++) {
               $user = new User();
               $password = 'azertyu';
               $user->setEmail($faker->email());
               $user->setLastname($faker->lastName());
               $user->setFirstname($faker->firstName());
               //$user[$i]->setRoles($faker->randomDigit);
               $user->setAdress($faker->address());
               $user->setPhone($faker->phoneNumber());
               $user->setImage($faker->image());
               //$user->setCreatedAt($faker->dateTime($max = 'now', $timezone = null));
               $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $password,
                )); 
               $userList[] = $user;
               $manager->persist($user);
           }
           print 'GG BG';
           $manager->flush();
/*
           // on crée 4 teachers avec email, noms, prénoms et une image "aléatoires" en français
           $teacher = Array();
           print 'creation des profs';
           for ($i = 0; $i < 4; $i++) {
               $teacher[$i] = new Teacher();
               $teacher[$i]->setEmail($faker->email);
               $teacher[$i]->setLastname($faker->lastName);
               $teacher[$i]->setFirstname($faker->firstName);
               //$teacher[$i]->setRoles($faker->text());
               $teacher[$i]->setImage($faker->image());
               //$teacher[$i]->setCreatedAt($faker->date($format = Y-m-d, $Max = 'now')); 
               $manager->persist($teacher[$i]);
           }

           // on crée 4 salles de classes 
           $class = Array();
           print 'creation des salles de classes';
           for ($i = 0; $i < 4; $i++) {
               $class[$i] = new Classroom();
               $class[$i]->setLetter($faker->randomElement($array =array('a', 'b', 'c', 'd')));
               $class[$i]->setGrade($faker->numberBetween($min = 3, $max = 6));
               $class[$i]->setTasks($faker->text($maxNbChars = 15 ));
               $class[$i]->setContent($faker->text($maxNbChars = 50 ));
               //$class[$i]->setCompleted($faker->);
               //$classes[$i]->setCreatedAt($faker->date($format = Y-m-d, $Max = 'now'));
               $manager->persist($class[$i]);
           }

           $dayList = [
               'lundi',
               'mardi',
               'mercredi',
               'jeudi',
               'vendredi',
               'samedi',
               'dimanche',
           ];

        $dayObjectList = [];
        print 'Création des jours';
        foreach ($dayList as $dayName) {
            $day = new Day();
            $day->setName($dayName);
            $dayObjectList[] = $day;
            $manager->persist($day);
        }

        // on crée 4 salles de classes 
        $planning = Array();
        print 'creation des planning';
        for ($i = 0; $i < 4; $i++){

            $planning = new Planning();

            $planning[$i]->setBegin($faker->date($format = Y-m-d, $Max = 'now'));
            $planning[$i]->setFinish($faker->dateTimeInInterval($date = 'now', $interval = '+1 days', $timezone = null));
            //$planning[$i]->setCreatedAt($faker->date($format = Y-m-d, $Max = 'now'));
        }
        
        $disciplineList = [
            'Francais',
            'Math',
            'SVT',
            'EPS',
            'Histoire-Géo',           
        ];

     $disciplineObjectList = [];
     print 'Création des jours';
     foreach ($disciplineList as $disciplineName) {
         $discipline = new Discipline();
         $day->setName($disciplineName);
         $disciplineObjectList[] = $discipline;
         $manager->persist($discipline);
     }

     // on crée des annonces 
     $announce = Array();
     print 'creation des annonces';
     for ($i = 0; $i < 4; $i++) {
         $announce[$i] = new Announce();
         $announce[$i]->setTitle($faker->title);
         $announce[$i]->setContent($faker->text($maxNbChars = 150));
         $announce[$i]->setImage($faker->image());
         $announce[$i]->setTask($faker->text($maxNbChars = 15 ));
         //$announce[$i]->setCompleted($faker->);
         

         //$classes[$i]->setCreatedAt($faker->date($format = Y-m-d, $Max = 'now'));
         $manager->persist($announce[$i]);
     }

     $categoryList = [
        'Vie scolaire',
        'Trucs et Astuces',
        'News',           
    ];

    $categoryObjectList = [];

    print 'Création des categories';

    foreach ($categoryList as $categoryName) {
        $category = new Category();
        $category->setName($categoryName);
        $categoryObjectList[] = $category;
        $manager->persist($category);
    }

    // on crée des notes 
    $note = Array();
    print 'creation des notes';
    for ($i = 0; $i < 4; $i++){
        $note = new Note;
        $note->setTitle($faker->title);
        $note->setGrade($faker->numberBetween($min = 1, $max = 20));
        $manager->persist($note);
    }

    // on crée des cours 
    $lesson = Array();
    print 'creation des cours';
    for ($i = 0; $i < 5; $i++){
        $lesson = new Lesson;
        $lesson->setContent($faker->text($maxNbChars = 100));
        //$lesson->setIsPrivate($faker->);
        $manager->persist($lesson);
    }


    // TODO $note $lessons


*/
        
    }
}
