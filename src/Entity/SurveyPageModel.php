<?php


namespace App\Entity;


use App\Repository\SurveyQuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class SurveyPageModel
{
  protected $questions;
  protected $answers;


    public function __construct(SurveyQuestionsRepository $repository,Survey $survey, User $user)
    {
        $this->questions = new ArrayCollection($repository->findUnansweredQuestions($survey,$user)->getResult());
        $this->answers = new ArrayCollection();

        foreach ($this->questions as $question)
        {
            /** @var SurveyQuestion $question */
            /** @var SurveyAnswer $answer */
            $answer = new SurveyAnswer();
            $answer->setQuestion($question);
            $answer->setUser($user);
            $this->answers->add($answer);
        }

    }

    public function isFinished(): bool
    {
        if ($this->questions->count() > 0) {
            return false;
        }

        return true;
    }

    /**
     * @return Collection|SurveyQuestion[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }


    /**
     * @return Collection|SurveyAnswer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }



}
