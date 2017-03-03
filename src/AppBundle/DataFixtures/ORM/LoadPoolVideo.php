<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\PoolVideo;


class LoadPoolVideo implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pv1 = new PoolVideo();
        $pv1->setLibelle('Base PHP');
        $manager->persist($pv1);


        $pv2 = new PoolVideo();
        $pv2->setLibelle('Base de donnée');
        $manager->persist($pv2);

        $pv3 = new PoolVideo();
        $pv3->setLibelle('POO');
        $manager->persist($pv3);

        $manager->flush();
    }
}