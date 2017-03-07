<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\hasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 * @UniqueEntity(fields="title", message="Une question existe déjà avec ce titre.")
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PoolQuestion", inversedBy="questions")
     */
    private $poolQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255,nullable=true)
     * 
     */
    private $extension;

    private $file;

    private $tempFilename;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Response", mappedBy="question")
    */
    private $responses;




    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

    /**
    * @param Response $response
    */
    public function addResponse(Response $response)
    {
        $this->responses->add($response);
    }

    /**
    * @param Response $response
    */
    public function removeResponse(Response $response)
    {
        $this->responses->removeElement($response);
    }

    /**
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getResponses()
    {
        return $this->responses;
    }





    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Question
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Question
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Video
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }




    /**
     * Set poolQuestion
     *
     * @param \stdClass $poolQuestion
     *
     * @return poolQuestion
     */
    public function setPoolQuestion(PoolQuestion $poolQuestion)
    {
        $this->poolQuestion = $poolQuestion;

        return $this;
    }

    /**
     * Get poolQuestion
     *
     * @return \stdClass
     */
    public function getPoolQuestion()
    {
        return $this->poolQuestion;
    }








    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if (null !== $this->extension) {
            $this->tempFilename = $this->extension;

            $this->extension = null;
            $this->image = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }

        $this->extension = $this->file->guessExtension();
        $this->image = $this->file->getClientOriginalName();
    }

    /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(), 
            $this->id.'.'.$this->extension   
        );
        
    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->extension;
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }

        $this->poolQuestion->removeQuestion($this);
    }

    public function getUploadDir()
    {
        return 'uploads/questions';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getExtension();
    }


}

