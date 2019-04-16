<?php

namespace App\Repository;

use App\Entity\UserFinishedSurvey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserFinishedSurvey|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFinishedSurvey|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFinishedSurvey[]    findAll()
 * @method UserFinishedSurvey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserFinishedSurvey::class);
    }


}
