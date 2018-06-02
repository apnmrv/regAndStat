<?php

namespace App\Repository;

use App\Entity\LoginEvent;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LoginEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginEvent[]    findAll()
 * @method LoginEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct( $registry, LoginEvent::class);
    }

    /**
     * @param string $date
     * @return mixed
     * @throws \Exception
     */
    public function findUniqueForADay(string $date)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT 
                    SUBSTRING(le.loginDate, 1, 10),
                    COUNT(DISTINCT u.username)                    
                    FROM
                        App\Entity\LoginEvent le
                        LEFT JOIN le.user u
                    WHERE
                        le.loginDate = :d
                    GROUP BY le.loginDate'
            );
        $query->setParameter('d', $date);

        $result = $query->getResult();

        return $result;
    }

    /**
     * @param string $fromDate
     * @param string $tillDate
     * @return array
     */
    public function findVisitorsForAPeriod(string $fromDate,
                                          string $tillDate ) : array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT 
                        u.username username,
                        u.firstName firstName,
                        u.lastName lastName,
                        le.loginDate date,
                        COUNT(le.loginTime) times
                  FROM 
                        App\Entity\LoginEvent le
                        LEFT JOIN le.user u
                  WHERE 
                        le.loginDate BETWEEN :d1 AND :d2
                  GROUP BY le.loginDate, le.user');

        $query->setParameters(['d1' => $fromDate,
            'd2' => $tillDate]);

        $visitors = $query->getResult();

        return $visitors;
    }

//    /**
//     * @return LoginEvent[] Returns an array of LoginEvent objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LoginEvent
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
