<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Card;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Chemin vers votre fichier CSV
        $filename = './data_good.csv';

        // Vérifie si le fichier existe
        if (!file_exists($filename)) {
            throw new \Exception("Le fichier $filename n'existe pas.");
        }

        // Lecture du fichier CSV
        $handle = fopen($filename, "r");

        // Boucle à travers les lignes du fichier
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $entity = new Card();
            $entity->setId($data[0]);
            $entity->setCategory($data[1]);
            $entity->setQuestion($data[2]);
            $entity->setAnswer($data[3]);
            $entity->setTag($data[4]);
            $entity->setDate($data[5]);

            // Persiste l'entité
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
