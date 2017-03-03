<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PoolVideo;
use AppBundle\Form\PoolVideoType;
use AppBundle\Entity\Video;
use AppBundle\Form\VideoType;
use AppBundle\Form\ModifVideoType;

class BackendController extends Controller
{
    public function managePoolVideoAction()
    {
        $listPoolVideo = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:PoolVideo')
            ->findAll();

        return $this->render('Backend/listePoolVideo.html.twig', array(
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

        return $this->render('Backend/addPoolVideo.html.twig', array('form' => $form->createView()));
    }


    public function modifPoolVideoAction($id, Request $request)
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

        return $this->render('Backend/modifPoolVideo.html.twig', array('form' => $form->createView()));
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





    public function manageVideoAction()
    {
        $listVideo = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Video')
            ->findAll();

        return $this->render('Backend/listeVideo.html.twig', array(
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

        return $this->render('Backend/addVideo.html.twig', array('form' => $form->createView()));
    }


    public function modifVideoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $video = $em->getRepository('AppBundle:Video')
            ->find($id);

        $form = $this->createForm(ModifVideoType::class, $video);

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

        return $this->render('Backend/modifVideo.html.twig', array('form' => $form->createView()));
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
