<?php

namespace App\Controller;


use App\Entity\Survey;
use App\Entity\SurveyAnswer;
use App\Entity\SurveyPageModel;
use App\Entity\SurveyQuestion;
use App\Entity\User;
use App\Entity\UserFinishedSurvey;
use App\Form\SurveyPageType;
use Doctrine\Common\Collections\Collection;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{



    public function index()
    {
        return $this->redirectToRoute('take_survey');
    }

    public function takeSurvey(Request $request)
    {
        /** @var Survey $survey */
        $survey = $this->getDoctrine()->getRepository(Survey::class)
            ->getUnfinishedSurveys($this->getUser())->setMaxResults(1)->getOneOrNullResult();

        if (!$survey) {
            //show stats from last survey
            return $this->redirectToRoute('show_last_survey_stats');
        }

        $entityManager = $this->getDoctrine()->getManager();

        // Get not answered questions for survey page
        $questionPage = new SurveyPageModel($this->getDoctrine()->getRepository(SurveyQuestion::class), $survey,
            $this->getUser());

        if ($questionPage->isFinished()) {
            // survey is complete:
            // need to mark it as finished and show statpage else show survey page.
            $finishedSurvey = new UserFinishedSurvey($this->getUser(), $survey, true);
            $entityManager->persist($finishedSurvey);
            $entityManager->flush();

            return $this->redirectToRoute('show_last_survey_stats');
        }

        $form = $this->createForm(SurveyPageType::class, $questionPage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionPage = $form->getData();
            foreach ($questionPage->getAnswers() as $answer) {
                $entityManager->persist($answer);
            }
            $entityManager->flush();

            return $this->redirectToRoute('take_survey');
        }

        return $this->render('main/index.html.twig', [
            'survey_name' => $survey->getName(),
            'form' => $form->createView(),
        ]);
    }


    //Shows stats from last survey
    public function showLastStats()
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Survey $survey */
        $survey = $user->getUserSurveys()->last()->getSurvey();
        /** @var Collection|SurveyQuestion[] $questions */
        $questions = $survey->getQuestions();
        $questionsStat = [];
        $questionsStat2 = [];
        foreach ($questions as $question) {
            $questionsStat[$question->getId()] = $this->getDoctrine()->getRepository(SurveyAnswer::class)
                ->getAnswersMeanValue($question);
            $questionsStat2[$question->getId()] = $this->getDoctrine()->getRepository(SurveyAnswer::class)
                ->getStatsByValues($question);
        }

        return $this->render('main/stats.html.twig', [
            'survey_name' => $survey->getName(),
            'questions' => $questions,
            'dataset' => implode(",", $questionsStat),
            'dataset2' => $questionsStat2,
        ]);

    }

    //Shows list of registered users who not passed the survey
    public function userStatistics(Request $request, PaginatorInterface $paginator)
    {
        //Get Last survey
        $survey = $this->getDoctrine()->getRepository(Survey::class)->findOneBy([], ['id' => 'DESC']);


        $q = $this->getDoctrine()->getRepository(User::class)->getUsersNotFinishedSurvey($survey);
        $pagination = $paginator->paginate(
            $q,
            $request->query->getInt('page', 1),
            $this->getParameter('records_per_page')
        );

        return $this->render('main/userStats.html.twig', [
            'survey_name' => $survey->getName(),
            'pagination' => $pagination,
        ]);
    }
}
