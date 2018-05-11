<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserMilestoneStatusRepository")
 */
class UserMilestoneStatus
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="milestoneStatus")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Milestone", inversedBy="userStatus")
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

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $submittedOn;

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

    public function getSubmittedOn(): ?\DateTimeInterface
    {
        return $this->submittedOn;
    }

    public function setSubmittedOn(?\DateTimeInterface $submittedOn): self
    {
        $this->submittedOn = $submittedOn;

        return $this;
    }
}
