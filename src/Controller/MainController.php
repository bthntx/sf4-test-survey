<?php

namespace App\Controller;


use App\Entity\Survey;
use App\Entity\SurveyPageModel;
use App\Entity\SurveyQuestion;
use App\Form\SurveyPageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{



    public function index()
    {
        return $this->redirectToRoute('take_survey');
    }

    public function takeSurvey()
    {
        /** @var Survey $survey */
        $survey = $this->getDoctrine()->getRepository(Survey::class)
            ->getUnfinishedSurveys($this->getUser())->setMaxResults(1)->getOneOrNullResult();


        $questions = $this->getDoctrine()->getRepository(SurveyQuestion::class)
            ->findUnansweredQuestions($survey, $this->getUser());


        $questionPage = new SurveyPageModel($this->getDoctrine()->getRepository(SurveyQuestion::class), $survey,
            $this->getUser());


        $form = $this->createForm(SurveyPageType::class, $questionPage);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
        ]);
    }
}
