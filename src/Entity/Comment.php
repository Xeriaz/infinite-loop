<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $postedOn;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Challenges", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $challenge;

    public function getId()
    {
        return $this->id;
    }

    public function getPostedOn(): ?\DateTimeInterface
    {
        return $this->postedOn;
    }

    public function setPostedOn(\DateTimeInterface $postedOn): self
    {
        $this->postedOn = $postedOn;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getChallenge(): ?Challenges
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenges $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }
}
