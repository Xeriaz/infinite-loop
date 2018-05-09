<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserMilestoneRepository")
 */
class UserMilestone
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="milestone")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Milestone", inversedBy="user")
     * @ORM\JoinColumn(name="milestone_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $milestone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCompleted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFailed = false;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMilestone()
    {
        return $this->milestone;
    }

    public function setMilestone($milestone): self
    {
        $this->milestone = $milestone;

        return $this;
    }

    public function getIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsFailed(): ?bool
    {
        return $this->isFailed;
    }

    public function setIsFailed(bool $isFailed): self
    {
        $this->isFailed = $isFailed;

        return $this;
    }
}
