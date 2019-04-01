<?php

namespace Entidades;

use Doctrine\ORM\Mapping as ORM;

/**
 * Students
 *
 * @ORM\Table(name="students")
 * @ORM\Entity
 */
class Students
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
     * @var string|null
     *
     * @ORM\Column(name="regional", type="string", length=45, nullable=true)
     */
    private $regional;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=240, nullable=true)
     */
    private $name;


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
     * Set regional.
     *
     * @param string|null $regional
     *
     * @return Students
     */
    public function setRegional($regional = null)
    {
        $this->regional = $regional;

        return $this;
    }

    /**
     * Get regional.
     *
     * @return string|null
     */
    public function getRegional()
    {
        return $this->regional;
    }

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Students
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
}
