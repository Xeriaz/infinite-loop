<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="ChallengeGroupRepository")
 */
class ChallengeGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $groupName;

    /**
     * @ORM\ManyToMany(targetEntity="Challenge.php", mappedBy="challengeGroup")
     */
    private $challenge;

    public function __construct()
    {
        $this->challenge = new ArrayCollection();
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
    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     * @return ChallengeGroup
     */
    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenge->contains($challenge)) {
            $this->challenge[] = $challenge;
            $challenge->addChallengeGroup($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenge->contains($challenge)) {
            $this->challenge->removeElement($challenge);
            $challenge->removeChallengeGroup($this);
        }

        return $this;
    }
}
