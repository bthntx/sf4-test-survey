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
     * @ORM\OneToMany(targetEntity="UserFinishedSurvey", mappedBy="user", orphanRemoval=true)
     */
    private $userSurveys;

    public function __construct()
    {
        parent::__construct();
        $this->userSurveys = new ArrayCollection();
    }

    /**
     * @return Collection|UserFinishedSurvey[]
     */
    public function getUserSurveys(): Collection
    {
        return $this->userSurveys;
    }

    public function addUserSurvey(UserFinishedSurvey $userSurvey): self
    {
        if (!$this->userSurveys->contains($userSurvey)) {
            $this->userSurveys[] = $userSurvey;
            $userSurvey->setUser($this);
        }

        return $this;
    }

    public function removeUserSurvey(UserFinishedSurvey $userSurvey): self
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
