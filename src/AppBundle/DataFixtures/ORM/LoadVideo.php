<?php

namespace AppBundle\DateFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Video;

Class LoadVideo implements FixtureInterface
{
    public function Load(ObjectManager $manager)
    {
        $video1 = new Video();
        $video1->setTitle('Tuto POO');
        $video1->setExtension(".mkv");
        $video1->setDescription("Vous allez trouver un tas de truc passionnat en regardant cette belle video ! ");

        $manager->persist($video1);

        $video2 = new Video();
        $video2->setTitle('Tuto Base PHP');
        $video2->setExtension(".avi ");
        $video2->setDescription("C'est pour les gros null ici, on reprend vraiment toutes les bases. SI avec cela vous etes toujours perdus, changez de metier ! ");

        $manager->persist($video2);


        $video3 = new Video();
        $video3->setTitle('Tuto Base de donnée');
        $video3->setExtension(".avi");
        $video3->setDescription("C'est le tuto le plus fun de tous, ici tu va apprendre a tout garder, comment tout répertorier ! ");

        $manager->persist($video3);


        $manager->flush();
    }
}
