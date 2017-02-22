<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;


class SubscribeType extends AbstractType
{
	public function buildform(FormBuilderInterface $builder, array $option)
	{
		$builder->add('username', TextType::class)
                ->add('password', PasswordType::class)
                ->add('email',    EmailType::class)
               // ->add('save',     SubmitType::class)
        ;        
	}
}
