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
     * @ORM\Column(type="boolean", name="is_completed")
     */
    private $completed = false;

    /**
     * @ORM\Column(type="boolean", name="is_deleted")
     */
    private $deleted = false;

    /**
     * @ORM\Column(type="boolean", name="is_failed")
     */
    private $failed = false;

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

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getFailed(): ?bool
    {
        return $this->failed;
    }

    public function setFailed(bool $failed): self
    {
        $this->failed = $failed;

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
