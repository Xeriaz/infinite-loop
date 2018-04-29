<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MilestoneRepository")
 */
class Milestone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completedOn;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Challenges", inversedBy="milestones")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id")
     */
    private $challenge;

    /**
     * @return mixed
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * @param mixed $challenge
     */
    public function setChallenge($challenge): void
    {
        $this->challenge = $challenge;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Milestone
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return Milestone
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCompletedOn(): ?\DateTimeInterface
    {
        return $this->completedOn;
    }

    /**
     * @param \DateTimeInterface|null $completedOn
     * @return Milestone
     */
    public function setCompletedOn(?\DateTimeInterface $completedOn): self
    {
        $this->completedOn = $completedOn;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return Milestone
     */
    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
