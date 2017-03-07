<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\PoolVideo;
use AppBundle\Form\PoolVideoType;

class BackendPoolVideoController extends Controller
{
    public function managePoolVideoAction()
    {
        $listPoolVideo = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:PoolVideo')
            ->findAll();

        return $this->render('Backend/listPoolVideo.html.twig', array(
            'listPoolVideo' => $listPoolVideo,
        ));
    }

    public function addPoolVideoAction(Request $request)
    {
        $poolVideo = new PoolVideo();

        $form = $this->createForm(PoolVideoType::class, $poolVideo);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($poolVideo);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Pool Video bien enregistrée');

                return $this->redirectToRoute('pool_video_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/addPoolVideo.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editPoolVideoAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $poolVideo = $em->getRepository('AppBundle:PoolVideo')
            ->find($id);

        if (null == $poolVideo) {
            throw new NotFoundHttpException("Error Pool Video with id ".$id." don't exist.");
        }

        $form = $this->createForm(PoolVideoType::class, $poolVideo);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($poolVideo);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Pool Video bien enregistrée');

                return $this->redirectToRoute('pool_video_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/editPoolVideo.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function deletePoolVideoAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $poolVideo = $em->getRepository('AppBundle:PoolVideo')
            ->find($id);

        if (null == $poolVideo) {
            throw new NotFoundHttpException("Error Pool Video with id ".$id." don't exist.");
        }


        $em->remove($poolVideo);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('info', "l'annonce est bien supprimée.");

        return $this->redirectToRoute('pool_video_manage');
    }
}