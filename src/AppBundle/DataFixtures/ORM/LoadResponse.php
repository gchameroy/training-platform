<?php

namespace AppBundle\DateFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Response;

Class LoadResponse implements FixtureInterface
{
    public function Load(ObjectManager $manager)
    {
        $response1 = new Response();
        $response1->setTitle('Manger des pommes le lundi soir');
        $response1->setIsFair(false);

        $manager->persist($response1);

       
        $response2 = new Response();
        $response2->setTitle('Se promener sur le lac');
        $response2->setIsFair(false);

        $manager->persist($response2);


        $response3 = new Response();
        $response3->setTitle('Rire de ses propres blagues');
        $response3->setIsFair(true);

        $manager->persist($response3);


        $response4 = new Response();
        $response4->setTitle('Essayer un nouveau manteau');
        $response4->setIsFair(false);

        $manager->persist($response4);




        $manager->flush();
    }
}
