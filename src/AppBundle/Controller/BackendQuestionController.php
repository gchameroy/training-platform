<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Question;
use AppBundle\Form\Type\QuestionType;
use AppBundle\Form\Type\EditQuestionType;



class BackendQuestionController extends Controller
{
    public function manageQuestionAction()
    {
        $listQuestion = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Question')
            ->findAll();

        return $this->render('Backend/listQuestion.html.twig', array(
            'listQuestion' => $listQuestion,
        ));
    }

    public function addQuestionAction(Request $request)
    {
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($question);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Question bien enregistrée');

                return $this->redirectToRoute('question_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/addQuestion.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editQuestionAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('AppBundle:Question')
            ->find($id);

        if (null === $question) {
            throw new NotFoundHttpException("Error Question with id ".$id." don't exist.");
        }

        $form = $this->createForm(EditQuestionType::class, $question);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($question);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Question bien modifiée');
                return $this->redirectToRoute('question_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/editQuestion.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteQuestionAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $question = $em->getRepository('AppBundle:Question')->find($id);

        if (null === $question) {
            throw new NotFoundHttpException("Error Question with id ".$id." don't exist.");
        }


        $em->remove($question);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('info', "la question est bien supprimée.");

        return $this->redirectToRoute('question_manage');
    }
}
