<?php

namespace AppBundle\DateFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Question;

Class LoadQuestion implements FixtureInterface
{
    public function Load(ObjectManager $manager)
    {
        $question1 = new Question();
        $question1->setTitle('Question POO');
        $question1->setImage("/upload/images/toto.jpeg");
        $question1->setExtension(".jpeg");

        $manager->persist($question1);

        
        $question2 = new Question();
        $question2->setTitle('Question BDD');
        $question2->setImage("/upload/images/kiri.jpeg");
        $question2->setExtension(".jpeg");

        $manager->persist($question2);


        $question3 = new Question();
        $question3->setTitle('Question PHP');
        $question3->setImage("/upload/images/shamalow.jpeg");
        $question3->setExtension(".jpeg");

        $manager->persist($question3);





        $manager->flush();
    }
}