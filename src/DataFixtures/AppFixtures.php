<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Cours;
use App\Entity\Etape;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    private $logger;


    public function __construct(UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger)
    {
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
    }
   
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 1 creer tes cours et tu les met dans un tableau (tableau d'objet)

        // 2 => creer un admin

        // 3 => creer 5 formateurs

        // 4 => creer 10 user avec une boucle
            // au moment de la boucle, tu vas ajouter 3 cours (objet cours grace a ta methode add)
            // essaye de faire en sorte qu'il n'y ai pas deux fois le meme cours

        $listeCours = [];
        // $plainPasswords = [];
        $courseData = require __DIR__ . '/../Data/course_data.php';

         // Générer des cours
        foreach ($courseData as $courseName => $courseDescription) {
            $cours = new Cours();
            $cours->setTitre($courseName);
            $cours->setDescription($courseDescription);
            $listeCours[] = $cours;
           
            $manager->persist($cours);
        }
        
        
        // Générer un admin
        
        $admin = new User();
            $admin->setNom($faker->lastName());
            $admin->setPrenom($faker->firstName());
            $admin->setEmail($faker->email());
            $plainPassword ="admin";
            $hashedPassword = $this->passwordHasher->hashPassword($admin, $plainPassword);
            $admin->setPassword($hashedPassword);
            $admin->setRoles(['ROLE_ADMIN']);
           
            $manager->persist($admin);
            
            $this->logger->info('Administrateur généré.');

        // Générer 5 formateurs

        for ($i = 0; $i < 5; $i++) {
            $formateur = new User();
            $formateur->setNom($faker->lastName());
            $formateur->setPrenom($faker->firstName());
            $formateur->setEmail($faker->email());
            $plainPassword = "formateur";
            $hashedPassword = $this->passwordHasher->hashPassword($formateur, $plainPassword);
            $formateur->setPassword($hashedPassword);
            $formateur->setRoles(['ROLE_FORMATEUR']);
           
            $manager->persist($formateur);
        }
        
        $this->logger->info('Formateurs générés.');


        // Générer 10 étudiants et leur associer 3 cours
        for ($i = 0; $i < 10; $i++) {
            $etudiant = new User();
            $etudiant->setNom($faker->lastName());
            $etudiant->setPrenom($faker->firstName());
            $etudiant->setEmail($faker->email());
            $plainPassword = "etudiant";
            
            for($j=0; $j<3;$j++){
                $etudiant->addCour($listeCours[rand(0,9)]);
            }
            
            $hashedPassword = $this->passwordHasher->hashPassword($etudiant, $plainPassword);
            $etudiant->setPassword($hashedPassword);
            $etudiant->setRoles(['ROLE_ETUDIANT']);
           
            $manager->persist($etudiant);
        }
       
        $this->logger->info('Étudiants générés.');


            // Inclure les données des étapes à partir du fichier externe
            $stepData = require __DIR__ . '/../Data/course_step_data.php';
            
            // Générer des étapes

       
            foreach($listeCours as $cours){

                if (isset($stepData[$cours->getTitre()])) {
                    $stepsForCourse = $stepData[$cours->getTitre()];
                    foreach ($stepsForCourse as $step) {
                        $etape = new Etape();
                        $etape->setTitre($step['titre']);
                        $etape->setDescription($step['description']);
                        $etape->setContenu($faker->url());
                        $etape->setCours($cours);
    
                        $manager->persist($etape);
                    }
                }


            }
        

        $manager->flush();
    }
}
