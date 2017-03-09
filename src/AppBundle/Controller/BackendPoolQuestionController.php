<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\PoolQuestion;
use AppBundle\Form\Type\PoolQuestionType;

class BackendPoolQuestionController extends Controller
{
    public function managePoolQuestionAction()
    {
        $listPoolQuestion = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:PoolQuestion')
            ->findAll();

        return $this->render('Backend/listPoolQuestion.html.twig', array(
            'listPoolQuestion' => $listPoolQuestion,
        ));
    }

    public function addPoolQuestionAction(Request $request)
    {
        $poolQuestion = new PoolQuestion();

        $form = $this->createForm(PoolQuestionType::class, $poolQuestion);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($poolQuestion);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Pool Question bien enregistrée');

                return $this->redirectToRoute('pool_question_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/addPoolQuestion.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editPoolQuestionAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $poolQuestion = $em->getRepository('AppBundle:PoolQuestion')
            ->find($id);

        if (null === $poolQuestion) {
            throw new NotFoundHttpException("Error Pool Question with id ".$id." don't exist.");
        }

        $form = $this->createForm(PoolQuestionType::class, $poolQuestion);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em->persist($poolQuestion);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Pool Question bien enregistrée');

                return $this->redirectToRoute('pool_question_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/editPoolQuestion.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function deletePoolQuestionAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $poolQuestion = $em->getRepository('AppBundle:PoolQuestion')
            ->find($id);

        if (null === $poolQuestion) {
            throw new NotFoundHttpException("Error Pool Question with id ".$id." don't exist.");
        }

        $em->remove($poolQuestion);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('info', "l'annonce est bien supprimée.");

        return $this->redirectToRoute('pool_question_manage');
    }
}
