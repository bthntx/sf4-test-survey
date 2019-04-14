<?php

namespace App\Repository;

use App\Entity\Survey;
use App\Entity\UserSurvey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSurvey|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSurvey|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSurvey[]    findAll()
 * @method UserSurvey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSurvey::class);
    }


    // /**
    //  * @return UserSurvey[] Returns an array of UserSurvey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserSurvey
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
