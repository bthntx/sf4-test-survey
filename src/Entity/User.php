<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends  BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSurvey", mappedBy="user", orphanRemoval=true)
     */
    private $userSurveys;

    public function __construct()
    {
        parent::__construct();
        $this->userSurveys = new ArrayCollection();
    }

    /**
     * @return Collection|UserSurvey[]
     */
    public function getUserSurveys(): Collection
    {
        return $this->userSurveys;
    }

    public function addUserSurvey(UserSurvey $userSurvey): self
    {
        if (!$this->userSurveys->contains($userSurvey)) {
            $this->userSurveys[] = $userSurvey;
            $userSurvey->setUser($this);
        }

        return $this;
    }

    public function removeUserSurvey(UserSurvey $userSurvey): self
    {
        if ($this->userSurveys->contains($userSurvey)) {
            $this->userSurveys->removeElement($userSurvey);
            // set the owning side to null (unless already changed)
            if ($userSurvey->getUser() === $this) {
                $userSurvey->setUser(null);
            }
        }

        return $this;
    }

}
