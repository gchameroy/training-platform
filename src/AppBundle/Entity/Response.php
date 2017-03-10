<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Response
 *
 * @ORM\Table(name="response")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResponseRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="title", message="Une réponse existe déjà avec ce titre.")
 */
class Response
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
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="is_fair", type="boolean")
     */
    private $isFair;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Question", inversedBy="responses")
     */
    private $question;







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
     * @return Response
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
     * Set isFair
     *
     * @param boolean $isFair
     *
     * @return Response
     */
    public function setFair($fair)
    {
        $this->isFair = $fair;

        return $this;
    }

    /**
     * Get isFair
     *
     * @return bool
     */
    public function isFair()
    {
        return $this->isFair;
    }

     /**
     * Set question
     *
     * @param \stdClass $question
     *
     * @return Question
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \stdClass
     */
    public function getQuestion()
    {
        return $this->question;
    }
}

