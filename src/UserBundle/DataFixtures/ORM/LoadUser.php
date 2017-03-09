<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadUser implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var  ContainerInterface
     */
    
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    } 


    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('gael');

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user1, 'gaelpass' );
        $user1->setPassword($encoded);

        $user1->setEmail('gael@gmail.com');
        $user1->setRoles(array('ROLE_USER'));

        $manager->persist($user1);



        $user2 = new User();
        $user2->setUsername('cyrille');

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user2, 'futepass' );
        $user2->setPassword($encoded);

        $user2->setEmail('cyrille@gmail.com');
        $user2->addRole('ROLE_ADMIN');

        $manager->persist($user2);



        $manager->flush();
        
    }
}
