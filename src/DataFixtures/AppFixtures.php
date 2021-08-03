<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Ville;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // on créer 20 villes
        $ville = Array();
        for ($i = 0; $i < 20; $i++) {
            $ville[$i] = new Ville();
            $ville[$i]->setNom($faker->city());
            $ville[$i]->setCodePostal("XXXXX");
            $manager->persist($ville[$i]);
        }

        // on créer 30 lieux
        $lieu = Array();
        for ($i = 0; $i < 30; $i++) {
            $lieu[$i] = new Lieu();
            $lieu[$i]->setNom($faker->city);
            $lieu[$i]->setRue($faker->streetName);
            $lieu[$i]->setLatitude($faker->latitude($min = -90, $max = 90));
            $lieu[$i]->setLongitude($faker->longitude($min = -180, $max = 180));
            $lieu[$i]->setVille($ville[$faker->numberBetween($min = 0, $max = count($ville) -1)]);
            $manager->persist($lieu[$i]);
        }

        // on créer 5 états
        $etat = Array();
        for ($i = 0; $i < 5; $i++) {
            $etat[$i] = new Etat();
            $etat[$i]->setLibelle($faker->word);
            $manager->persist($etat[$i]);
        }

        // on créer 150 participants
        $participant = Array();
        for ($i = 0; $i < 150; $i++) {
            $participant[$i] = new Participant();
            $participant[$i]->setPrenom($faker->firstName);
            $participant[$i]->setNom($faker->lastName);
            $participant[$i]->setTelephone("06XXXXXXXX");
            $participant[$i]->setEmail($faker->email);
            $participant[$i]->setPassword($faker->password);
            $participant[$i]->setIsActif(true);
            $participant[$i]->setPseudo($faker->userName);

            $manager->persist($participant[$i]);
        }

        // on créer 10 campus
        $campus = Array();
        for ($i = 0; $i < 10; $i++) {
            $campus[$i] = new Campus();
            $campus[$i]->setNom($faker->company);
            $manager->persist($campus[$i]);
        }

        // on créer 30 sorties
        $sortie = Array();
        for ($i = 0; $i < 30; $i++) {
            $sortie[$i] = new Sortie();
            $sortie[$i]->setNom($faker->sentence($nbWords = 4, $variableNbWords = true));
            $sortie[$i]->setdateHeureDebut($faker->dateTimeThisMonth($max = 'now', $timezone = null));
            $sortie[$i]->setDuree($faker->dateTimeThisMonth($max = 'now', $timezone = null));
            $sortie[$i]->setDateLimiteInscription($faker->dateTimeThisMonth($max = 'now', $timezone = null));
            $sortie[$i]->setNbInscriptionMax($faker->randomDigit);
            $sortie[$i]->setInfosSortie($faker->sentence);

            $sortie[$i]->setEtat($etat[$faker->numberBetween($min = 0, $max = count($etat) - 1 )]);
            $sortie[$i]->setLieu($lieu[$faker->numberBetween($min = 0, $max = count($lieu) - 1 )]);
            $sortie[$i]->setCampus($campus[$faker->numberBetween($min = 0, $max = count($campus) - 1 )]);
            $sortie[$i]->setOrganisateur($participant[$faker->numberBetween($min = 5, $max = count($participant) - 1 )]);
            for($j = 0; $j < $faker->numberBetween($min = 1, 20 ); $j++){
                $sortie[$i]->addParticipant($participant[$faker->numberBetween($min = 0, $max = count($participant) - 1 )]);
            }

            $manager->persist($sortie[$i]);
        }

        $manager->flush();
    }
}
