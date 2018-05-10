<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity="UserMilestoneStatus", mappedBy="milestone")
     */
    private $userStatus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Challenges", inversedBy="milestones")
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id")
     */
    private $challenge;

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
}
