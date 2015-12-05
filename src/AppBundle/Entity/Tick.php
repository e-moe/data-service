<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tick
 *
 * @ORM\Table(name="tick")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TickRepository")
 */
class Tick
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
     * @ORM\Column(name="val", type="string", length=255)
     */
    private $val;

    /**
     * @var int
     *
     * @ORM\Column(name="tick_key_id", type="integer")
     */
    private $tickKeyId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;


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
     * Set tickKeyId
     *
     * @param integer $tickKeyId
     *
     * @return Tick
     */
    public function setTickKeyId($tickKeyId)
    {
        $this->tickKeyId = $tickKeyId;

        return $this;
    }

    /**
     * Get tickKeyId
     *
     * @return int
     */
    public function getTickKeyId()
    {
        return $this->tickKeyId;
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

