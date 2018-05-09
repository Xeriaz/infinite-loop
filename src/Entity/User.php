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
     * @ORM\OneToMany(targetEntity="App\Entity\UserMilestone", mappedBy="user")
     */
    private $milestone;

    /**
     * @return mixed
     */
    public function getMilestone()
    {
        return $this->milestone;
    }

    /**
     * @param mixed $milestone
     */
    public function setMilestone($milestone): void
    {
        $this->milestone = $milestone;
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
        $this->challenges = new ArrayCollection();
        $this->milestone = new ArrayCollection();
    }

    public function addChallenge(Challenges $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->addUserChallenge($this);
        }

        return $this;
    }

    public function removeChallenge(Challenges $challenge): self
    {
        if ($this->challenges->contains($challenge)) {
            $this->challenges->removeElement($challenge);
            $challenge->removeUserChallenge($this);
        }

        return $this;
    }

    public function addMilestone(UserMilestone $milestone): self
    {
        if (!$this->milestone->contains($milestone)) {
            $this->milestone[] = $milestone;
            $milestone->setUser($this);
        }

        return $this;
    }

    public function removeMilestone(UserMilestone $milestone): self
    {
        if ($this->milestone->contains($milestone)) {
            $this->milestone->removeElement($milestone);
            // set the owning side to null (unless already changed)
            if ($milestone->getUser() === $this) {
                $milestone->setUser(null);
            }
        }

        return $this;
    }

}