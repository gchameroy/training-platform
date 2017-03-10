<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Repository\QuestionRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EditResponseType extends AbstractType
{
    public function buildform(FormBuilderInterface $builder, array $option)
    {
        $builder->add('title', TextType::class)
                ->add('isFair', CheckboxType::class, array(
                    'label' =>  'Bonne réponse ',
                    'required'  =>  false
                ))
                ->add('question', EntityType::class, array(
                        'class' => 'AppBundle:Question',
                        'query_builder' => function (QuestionRepository $qr) {
                            return $qr->createQueryBuilder('pr');
                        },
                        'choice_label' => 'title',
                )) 
        ;        
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Response'
        ));
    }
}
