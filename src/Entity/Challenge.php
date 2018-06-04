<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ChallengeRepository")
 */
class Challenge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", name="is_public")
     */
    private $public = false;

    /**
     * @ORM\Column(type="boolean", name="is_completed")
     */
    private $completed = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $addProof = false;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completedOn;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToMany(targetEntity="User", inversedBy="challenges")
     * @ORM\JoinTable(name="user_challenges")
     * @var ArrayCollection
     */
    private $users;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ownedChallenge")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="Milestone", mappedBy="challenge", cascade={"remove"})
     * @var Collection
     */
    private $milestones;

    /**
     * @ORM\ManyToMany(targetEntity="ChallengeGroup", inversedBy="challenge")
     * @ORM\JoinTable(name="challenge_groups")
     * @var Collection
     */
    private $challengeGroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="challenge", cascade={"remove"})
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="challenge", orphanRemoval=true, cascade={"remove"})
     */
    private $comments;

    /**
     * @return mixed
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param mixed $public
     */
    public function setPublic($public): void
    {
        $this->public = $public;
    }

    /**
     * @return mixed
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @param mixed $completed
     */
    public function setCompleted($completed): void
    {
        $this->completed = $completed;
    }

    /**
     * @return mixed
     */
    public function getCompletedOn()
    {
        return $this->completedOn;
    }

    /**
     * @param mixed $completedOn
     */
    public function setCompletedOn($completedOn): void
    {
        $this->completedOn = $completedOn;
    }


    /**
     * @return Collection
     */
    public function getChallengeGroup(): Collection
    {
        return $this->challengeGroup;
    }

    /**
     * @param Collection $challengeGroup
     */
    public function setChallengeGroup(Collection $challengeGroup): void
    {
        $this->challengeGroup = $challengeGroup;
    }

    /**
     * @return Collection
     */
    public function getMilestones(): Collection
    {
        return $this->milestones;
    }

    /**
     * @param Collection $milestones
     */
    public function setMilestones(Collection $milestones): void
    {
        $this->milestones = $milestones;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
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
     * @return Challenge
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Challenge
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     * @return Challenge
     */
    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     * @return Challenge
     */
    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->milestones = new ArrayCollection();
        $this->challengeGroup = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @param User $user
     * @return Challenge
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    /**
     * @param User $user
     * @return Challenge
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @param Milestone $milestone
     * @return Challenge
     */
    public function addMilestone(Milestone $milestone): self
    {
        if (!$this->milestones->contains($milestone)) {
            $this->milestones[] = $milestone;
            $milestone->setChallenge($this);
        }

        return $this;
    }

    /**
     * @param Milestone $milestone
     * @return Challenge
     */
    public function removeMilestone(Milestone $milestone): self
    {
        if ($this->milestones->contains($milestone)) {
            $this->milestones->removeElement($milestone);
            // set the owning side to null (unless already changed)
            if ($milestone->getChallenge() === $this) {
                $milestone->setChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @param ChallengeGroup $challengeGroup
     * @return Challenge
     */
    public function addChallengeGroup(ChallengeGroup $challengeGroup): self
    {
        if (!$this->challengeGroup->contains($challengeGroup)) {
            $this->challengeGroup[] = $challengeGroup;
        }

        return $this;
    }

    /**
     * @param ChallengeGroup $challengeGroup
     * @return Challenge
     */
    public function removeChallengeGroup(ChallengeGroup $challengeGroup): self
    {
        if ($this->challengeGroup->contains($challengeGroup)) {
            $this->challengeGroup->removeElement($challengeGroup);
        }

        return $this;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAddProof(): ?bool
    {
        return $this->addProof;
    }

    public function setAddProof(bool $addProof): self
    {
        $this->addProof = $addProof;

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
            $comment->setChallenge($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getChallenge() === $this) {
                $comment->setChallenge(null);
            }
        }

        return $this;
    }
}
