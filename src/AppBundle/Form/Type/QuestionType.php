<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\PoolQuestionRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;




class QuestionType extends AbstractType
{
    public function buildform(FormBuilderInterface $builder, array $option)
    {
        $builder->add('title', TextType::class)
                ->add('file', FileType::class)
                ->add('poolQuestion', EntityType::class, array(
                        'class' => 'AppBundle:PoolQuestion',
                        'query_builder' => function (PoolQuestionRepository $pqr) {
                            return $pqr->createQueryBuilder('pq');
                        },
                        'choice_label' => 'title',
                ) 
            )
        ;        
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }
}
