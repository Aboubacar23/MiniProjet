<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Equipe;
use App\Entity\Etablissement;
use App\Entity\Membre;
use App\Entity\Statut;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker= \Faker\Factory::create();
        
        for($i=1; $i <=5 ; $i++){
            $equipe =new Equipe();
            $equipe->setNom("equipe n°$i");
            $manager->persist($equipe);

             for ($i=1; $i <=5 ; $i++)
             {

          
                 $statut=new Statut();
                 $statut->setNom("statut n°$i");
                 $manager->persist($statut);

                 for ($i=1; $i <=5 ; $i++)

                {
                    $etablissement= new Etablissement();
                    $etablissement->setNom("etablissement n°$i");
                    $manager->persist($etablissement);
            

                    for ($i=1; $i <=10 ; $i++) { 

                        $membre = new Membre();
                        $cinnnn= 10203+$i;
                        $membre->setCin($cinnnn);
                        $membre->setNom($faker->lastName);
                        $membre->setPrenom($faker->firstName);
                        $membre->setEmail($faker->email);
                        $membre->setAdresse($faker->address);
                        $membre->setStatut($statut);
                        $membre->setEquipe($equipe);
                        $membre->setEtablissement($etablissement);
                        $manager->persist($membre);
                    }
                }
        }

    }  

    for($i=1; $i <=10 ; $i++){
        $annonce =new Annonce();
        $annonce->setTitre($faker->title);
        $annonce->SetContenu($faker->realText($maxNbChars = 200, $indexSize = 2));
        $annonce->setDate($faker->dateTime);
        
        $manager->persist($annonce);
        
       
    }

    $manager->flush();

    }
}
