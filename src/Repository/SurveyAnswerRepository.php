<?php

namespace App\Repository;

use App\Entity\SurveyAnswer;
use App\Entity\SurveyQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SurveyAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SurveyAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SurveyAnswer[]    findAll()
 * @method SurveyAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyAnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SurveyAnswer::class);
    }


    /** Get average mean for each question
     * @param SurveyQuestion $question
     * @return float
     */
    public function getAnswersMeanValue(SurveyQuestion $question): float
    {

        $q = $this->createQueryBuilder('summ')
            ->andWhere('summ.question = :question')
            ->setParameter('question', $question)
            ->select('SUM(summ.value)');
        $summ = $q->getQuery()->getSingleScalarResult();
        $count = $q->select('COUNT(summ)')->getQuery()->getSingleScalarResult();

        return round(($summ / $count), 2);

    }

    public function getStatsByValues(SurveyQuestion $question): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.question = :question')
            ->setParameter('question', $question)
            ->select('SUM(a.value)')
            ->groupBy("a.value")
            ->select('a.value, COUNT(a) as summ')->getQuery()->getScalarResult();

    }
}
