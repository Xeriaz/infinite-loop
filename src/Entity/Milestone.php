<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="UserMilestoneStatus", mappedBy="milestone", cascade={"remove"})
     */
    private $userStatus;

    /**
     * @ORM\ManyToOne(targetEntity="Challenge", inversedBy="milestones")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id")
     */
    private $challenge;

    /**
     * @ORM\Column(type="boolean", name="is_public")
     */
    private $public = false;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ownedMilestone")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $owner;

    public function __construct()
    {
        $this->userStatus = new ArrayCollection();
    }

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
     * @return Collection|UserMilestoneStatus[]
     */
    public function getUserStatus(): Collection
    {
        return $this->userStatus;
    }

    public function addUser(UserMilestoneStatus $user): self
    {
        if (!$this->userStatus->contains($user)) {
            $this->userStatus[] = $user;
            $user->setUser($this);
        }

        return $this;
    }

    public function removeUser(UserMilestoneStatus $user): self
    {
        if ($this->userStatus->contains($user)) {
            $this->userStatus->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUser() === $this) {
                $user->setUser(null);
            }
        }

        return $this;
    }

    public function addUserStatus(UserMilestoneStatus $userStatus): self
    {
        if (!$this->userStatus->contains($userStatus)) {
            $this->userStatus[] = $userStatus;
            $userStatus->setMilestone($this);
        }

        return $this;
    }

    public function removeUserStatus(UserMilestoneStatus $userStatus): self
    {
        if ($this->userStatus->contains($userStatus)) {
            $this->userStatus->removeElement($userStatus);
            // set the owning side to null (unless already changed)
            if ($userStatus->getMilestone() === $this) {
                $userStatus->setMilestone(null);
            }
        }

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
