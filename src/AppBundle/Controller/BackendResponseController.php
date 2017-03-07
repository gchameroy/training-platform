<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Response;
use AppBundle\Form\ResponseType;
use AppBundle\Form\EditResponseType;

class BackendResponseController extends Controller
{
    public function manageResponseAction()
    {
        $listResponse = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Response')
            ->findAll();

        return $this->render('Backend/listResponse.html.twig', array(
            'listResponse' => $listResponse,
        ));
    }

    public function addResponseAction(Request $request)
    {
        $response = new Response();

        $form = $this->createForm(ResponseType::class, $response);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($response);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Reponse bien enregistrée');

                return $this->redirectToRoute('response_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/addResponse.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editResponseAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $response = $em->getRepository('AppBundle:Response')
            ->find($id);

        $form = $this->createForm(EditResponseType::class, $response);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($response);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Reponse bien modifiée');
                return $this->redirectToRoute('response_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/editResponse.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteResponseAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $response = $em->getRepository('AppBundle:Response')->find($id);

        if (null == $response) {
            throw new NotFoundHttpException("Error Response with id ".$id." don't exist.");
        }


        $em->remove($response);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('info', "la reponse est bien supprimée.");

        return $this->redirectToRoute('response_manage');
    }
}