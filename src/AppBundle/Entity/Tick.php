<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Tick
 *
 * @ORM\Table(name="tick")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TickRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Tick
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="val", type="string", length=255)
     * @JMS\Expose
     */
    private $val;

    /**
     * @var TickKey
     *
     * @ORM\ManyToOne(targetEntity="TickKey", cascade={"persist"})
     * @ORM\JoinColumn(name="tick_key_id", referencedColumnName="id", nullable=false)
     */
    private $key;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @JMS\Expose
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * Tick constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set val
     *
     * @param string $val
     *
     * @return Tick
     */
    public function setVal($val)
    {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return string
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * Set tick key
     *
     * @param TickKey $key
     *
     * @return Tick
     */
    public function setKey(TickKey $key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get tick key
     *
     * @return TickKey
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tick
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Tick
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}

