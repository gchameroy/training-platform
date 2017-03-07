<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\PoolVideoRepository;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EditVideoType extends AbstractType
{
    public function buildform(FormBuilderInterface $builder, array $option)
    {
        $builder->add('title', TextType::class)
                ->add('description', TextareaType::class)
                ->add('poolVideo', EntityType::class, array(
                        'class' => 'AppBundle:PoolVideo',
                        'query_builder' => function (PoolVideoRepository $pvr) {
                            return $pvr->createQueryBuilder('pv');
                        },
                        'choice_label' => 'title',
                )) 
        ;        
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Video'
        ));
    }
}