<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PoolQuestion;


class LoadPoolQuestion implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pq1 = new PoolQuestion();
        $pq1->setTitle('test Base PHP');
        $pq1->setRate(14);
        $manager->persist($pq1);


        $pq2 = new PoolQuestion();
        $pq2->setTitle('Test Base de donnée');
        $pq2->setRate(12,5);
        $manager->persist($pq2);

        $pq3 = new PoolQuestion();
        $pq3->setTitle('Test POO');
        $pq3->setRate(18);
        $manager->persist($pq3);

        $manager->flush();
    }
}
