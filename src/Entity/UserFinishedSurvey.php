<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSurveyRepository")
 */
class UserFinishedSurvey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userSurveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $finished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Survey")
     * @ORM\JoinColumn(nullable=false)
     */
    private $survey;


    /**
     * UserSurvey constructor.
     * @param $user
     * @param $survey
     */
    public function __construct(User $user, Survey $survey, bool $finished)
    {
        $this->setUser($user);
        $this->setSurvey($survey);
        if ($finished) {
            $this->setFinished(true);
            $this->setFinishedDate(new DateTime());
        }
    }


    public function getId(): ?int
    {
        return $this->id;
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


    public function getFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): self
    {
        $this->finished = $finished;

        return $this;
    }

    public function getFinishedDate(): DateTimeInterface
    {
        return $this->finishedDate;
    }

    public function setFinishedDate(DateTimeInterface $finishedDate): self
    {
        $this->finishedDate = $finishedDate;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }


}
