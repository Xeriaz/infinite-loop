<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChallangesGroupsRepository")
 */
class ChallangesGroups
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
    private $groupName;

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
     * @return ChallangesGroups
     */
    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }
}
