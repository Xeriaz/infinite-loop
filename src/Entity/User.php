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
     * @ORM\ManyToMany(targetEntity="Challenge", mappedBy="users")
     */
    private $challenges = [];

    /**
     * @ORM\OneToMany(targetEntity="UserMilestoneStatus", mappedBy="user")
     */
    private $milestoneStatus;

    /**
     * @ORM\OneToMany(targetEntity="Challenge.php", mappedBy="owner"))
     */
    private $ownedChallenge;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Milestone", mappedBy="owner")
     */
    private $ownedMilestone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user")
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @return mixed
     */
    public function getMilestoneStatus(): Collection
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
    public function getChallenges(): Collection
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
        $this->ownedChallenge = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ownedMilestone = new ArrayCollection();
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->addUser($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
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

    public function getOwnedChallenge(): Collection
    {
        return $this->ownedChallenge;
    }

    public function setOwnedChallenge(?Challenge $ownedChallenge): self
    {
        $this->ownedChallenge = $ownedChallenge;

        // set (or unset) the owning side of the relation if necessary
        $newOwner = $ownedChallenge === null ? null : $this;
        if ($newOwner !== $ownedChallenge->getOwner()) {
            $ownedChallenge->setOwner($newOwner);
        }

        return $this;
    }

    public function addOwnedChallenge(Challenge $ownedChallenge): self
    {
        if (!$this->ownedChallenge->contains($ownedChallenge)) {
            $this->ownedChallenge[] = $ownedChallenge;
            $ownedChallenge->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedChallenge(Challenge $ownedChallenge): self
    {
        if ($this->ownedChallenge->contains($ownedChallenge)) {
            $this->ownedChallenge->removeElement($ownedChallenge);
            // set the owning side to null (unless already changed)
            if ($ownedChallenge->getOwner() === $this) {
                $ownedChallenge->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Milestone[]
     */
    public function getOwnedMilestone(): Collection
    {
        return $this->ownedMilestone;
    }

    public function addOwnedMilestone(Milestone $ownedMilestone): self
    {
        if (!$this->ownedMilestone->contains($ownedMilestone)) {
            $this->ownedMilestone[] = $ownedMilestone;
            $ownedMilestone->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedMilestone(Milestone $ownedMilestone): self
    {
        if ($this->ownedMilestone->contains($ownedMilestone)) {
            $this->ownedMilestone->removeElement($ownedMilestone);
            // set the owning side to null (unless already changed)
            if ($ownedMilestone->getOwner() === $this) {
                $ownedMilestone->setOwner(null);
            }
        }

        return $this;
    }
}
