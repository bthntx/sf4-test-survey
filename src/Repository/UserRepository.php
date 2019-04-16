<?php

namespace App\Repository;

use App\Entity\Survey;
use App\Entity\User;
use App\Entity\UserFinishedSurvey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUsersNotFinishedSurvey(Survey $survey)
    {


        $subQ = $this->_em->createQueryBuilder('sq')->from(Survey::class, 's')
            ->leftJoin(UserFinishedSurvey::class, 'fs', 'WITH', 's.id=fs.survey')
            ->where('fs.finished = true')->andWhere('fs.survey = :survey')->select('IDENTITY(fs.user)');

        $q = $this->createQueryBuilder('u')
            ->where($subQ->expr()->notIn('u.id', $subQ->getDQL()))
            ->setParameter('survey', $survey)->orderBy('u.id', 'ASC');

        return $q;

    }
}
