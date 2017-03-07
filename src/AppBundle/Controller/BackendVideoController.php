<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Entity\Video;
use AppBundle\Form\VideoType;
use AppBundle\Form\EditVideoType;

class BackendVideoController extends Controller
{
    public function manageVideoAction()
    {
        $listVideo = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Video')
            ->findAll();

        return $this->render('Backend/listVideo.html.twig', array(
            'listVideo' => $listVideo,
        ));
    }
    
    public function addVideoAction(Request $request)
    {
        $video = new Video();

        $form = $this->createForm(VideoType::class, $video);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($video);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Video bien enregistrée');

                return $this->redirectToRoute('video_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/addVideo.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editVideoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $video = $em->getRepository('AppBundle:Video')
            ->find($id);

        $form = $this->createForm(EditVideoType::class, $video);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($video);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Video bien modifiée');
                return $this->redirectToRoute('video_manage');
            } else {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Formulaire non valide');
            }
        }

        return $this->render('Backend/editVideo.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteVideoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $video = $em->getRepository('AppBundle:Video')->find($id);

        if (null == $video) {
            throw new NotFoundHttpException("Error Video with id ".$id." don't exist.");
        }


        $em->remove($video);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('info', "la video est bien supprimée.");

        return $this->redirectToRoute('video_manage');
    }
}