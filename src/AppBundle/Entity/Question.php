<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
     * @ORM\Column(name="file", type="string", length=255)
     */
    private $file;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PoolQuestion", inversedBy="questions")
     */
    private $poolQuestion;



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
     * Set file
     *
     * @param string $file
     *
     * @return Question
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
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

}

