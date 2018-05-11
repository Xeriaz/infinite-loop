<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Challenges", mappedBy="users")
     */
    private $challenges = [];

    /**
     * @ORM\OneToMany(targetEntity="UserMilestoneStatus", mappedBy="user")
     */
    private $milestoneStatus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Challenges", mappedBy="owner"))
     */
    private $ownedChallenge;

    /**
     * @return mixed
     */
    public function getMilestoneStatus()
    {
        return $this->milestoneStatus;
    }

    /**
     * @param mixed $milestoneStatus
     */
    public function setMilestoneStatus($milestoneStatus): void
    {
        $this->milestoneStatus = $milestoneStatus;
    }

    /**
     * @return mixed
     */
    public function getChallenges()
    {
        return $this->challenges;
    }

    /**
     * @param mixed $challenges
     */
    public function setChallenges($challenges): void
    {
        $this->challenges = $challenges;
    }

    public function __construct()
    {
        parent::__construct();

        $this->challenges = new ArrayCollection();
        $this->milestoneStatus = new ArrayCollection();
    }

    public function addChallenge(Challenges $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->addUser($this);
        }

        return $this;
    }

    public function removeChallenge(Challenges $challenge): self
    {
        if ($this->challenges->contains($challenge)) {
            $this->challenges->removeElement($challenge);
            $challenge->removeUser($this);
        }

        return $this;
    }

    public function addMilestone(UserMilestoneStatus $milestone): self
    {
        if (!$this->milestoneStatus->contains($milestone)) {
            $this->milestoneStatus[] = $milestone;
            $milestone->setUser($this);
        }

        return $this;
    }

    public function removeMilestone(UserMilestoneStatus $milestone): self
    {
        if ($this->milestoneStatus->contains($milestone)) {
            $this->milestoneStatus->removeElement($milestone);
            // set the owning side to null (unless already changed)
            if ($milestone->getUser() === $this) {
                $milestone->setUser(null);
            }
        }

        return $this;
    }

    public function addMilestoneStatus(UserMilestoneStatus $milestoneStatus): self
    {
        if (!$this->milestoneStatus->contains($milestoneStatus)) {
            $this->milestoneStatus[] = $milestoneStatus;
            $milestoneStatus->setUser($this);
        }

        return $this;
    }

    public function removeMilestoneStatus(UserMilestoneStatus $milestoneStatus): self
    {
        if ($this->milestoneStatus->contains($milestoneStatus)) {
            $this->milestoneStatus->removeElement($milestoneStatus);
            // set the owning side to null (unless already changed)
            if ($milestoneStatus->getUser() === $this) {
                $milestoneStatus->setUser(null);
            }
        }

        return $this;
    }

    public function getOwnedChallenge(): ?Challenges
    {
        return $this->ownedChallenge;
    }

    public function setOwnedChallenge(?Challenges $ownedChallenge): self
    {
        $this->ownedChallenge = $ownedChallenge;

        // set (or unset) the owning side of the relation if necessary
        $newOwner = $ownedChallenge === null ? null : $this;
        if ($newOwner !== $ownedChallenge->getOwner()) {
            $ownedChallenge->setOwner($newOwner);
        }

        return $this;
    }

}