<?php

namespace AppBundle\EvenListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\Question;
use AppBundle\Entity\Video;
use AppBundle\FileUploader;


class FileUploadListener
{
    private $uploader;
    private $path_video;
    private $path_question;


    public function __construct(FileUploader $uploader, $path_question,  $path_video)
    {
        $this->uploader = $uploader;
        $this->path_question = $path_question;
        $this->path_video = $path_video;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        $path = '';
        
        if ($entity instanceof Video) {
            $path = $this->path_video;
        }
        if ($entity instanceof Question) {
            $path = $this->path_question;
        }
        
        $file = $entity->getFile();
        
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file,$path);
        $entity->setFile($fileName);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $file = $args->getEntity()->getFile();
        $filePath = $this->uploader->getTargetDir().$file;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }



}
