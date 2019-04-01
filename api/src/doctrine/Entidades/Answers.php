<?php

namespace Entidades;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answers
 *
 * @ORM\Table(name="answers")
 * @ORM\Entity
 */
class Answers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="student_id", type="integer", nullable=true)
     */
    private $studentId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="question_id", type="integer", nullable=true)
     */
    private $questionId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="alternative_id", type="integer", nullable=true)
     */
    private $alternativeId;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set studentId.
     *
     * @param int|null $studentId
     *
     * @return Answers
     */
    public function setStudentId($studentId = null)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get studentId.
     *
     * @return int|null
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set questionId.
     *
     * @param int|null $questionId
     *
     * @return Answers
     */
    public function setQuestionId($questionId = null)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId.
     *
     * @return int|null
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set alternativeId.
     *
     * @param int|null $alternativeId
     *
     * @return Answers
     */
    public function setAlternativeId($alternativeId = null)
    {
        $this->alternativeId = $alternativeId;

        return $this;
    }

    /**
     * Get alternativeId.
     *
     * @return int|null
     */
    public function getAlternativeId()
    {
        return $this->alternativeId;
    }
}
