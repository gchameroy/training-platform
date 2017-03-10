<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * PoolQuestion
 *
 * @ORM\Table(name="pool_question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PoolQuestionRepository")
 * @UniqueEntity(fields="title", message="Une Pool Question existe déjà avec ce titre.")
 */
class PoolQuestion
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
     * @assert\NotBlank()
     */
    private $title;

    /**
     * @var bool
     *
     * @ORM\Column(name="rate", type="decimal", scale=2)
     * @Assert\Range(
     *     min = 0, 
     *     max = 100,
     *     minMessage = "Min % is 0",
     *     maxMessage = "Max % is 100"
     * )
     */
    private $rate;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Question", mappedBy="poolQuestion")
     */
    private $questions;




    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * @param Question $question
     */
    public function addQuestion(Question $question)
    {
        $this->questions->add($question);
    }

    /**
     * @param  Question $question 
     */
    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
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
     * @return PoolQuestion
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
     * Set rate
     *
     * @param decimal $rate
     *
     * @return PoolQuestion
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return decimal
     */
    public function getRate()
    {
        return $this->rate;
    }
}

