<?php

namespace App\Repository;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use PHPUnit\Runner\Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;
use DoctrineExtensions\Query\MySQL;

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

    /**
     * @param string
     * @return User : Returns a User object with the given username
     * @throws
     */
    public function findOneByUsername(string $value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param DateTime $value
     * @return array
     */
    public function findByDateOfBirth(DateTime $value) : array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.dateOfBirth = :val')
            ->setParameter('val', $value)
            ->orderBy('u.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /**
     * @param string $dateFrom
     * @param string $dateTill
     * @return array
     */
    public function findAllByBirthday(string $dateFrom,
                                    string $dateTill) : array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT u
                    FROM App\Entity\User u
                    WHERE 
                        CONCAT (SUBSTRING(u.dateOfBirth, 6, 2), SUBSTRING(u.dateOfBirth, 9, 2)) 
                        BETWEEN 
                        CONCAT (:m1, :d1) 
                        AND
                        CONCAT (:m2, :d2)');
        $query->setParameters([
            'm1' => substr( $dateFrom, 5, 2),
            'd1' => substr( $dateFrom, 8, 2),
            'm2' => substr( $dateTill, 5, 2),
            'd2' => substr( $dateTill, 8, 2)
        ]);

        return $query->getResult();
    }

    /**
     * @param string $fromDate
     * @param string $tillDate
     * @return array
     */
    public function findAllByRegistrationDatesGroupByCity(string $fromDate,
                                                          string $tillDate) : array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT
                  c.name AS city, 
                  COUNT(u.id) AS registrations
                FROM App\Entity\User u
                LEFT JOIN u.city c
                LEFT JOIN u.registrationEvent re                  
                  WHERE re.registrationDate IS NOT NULL 
                  AND re.registrationDate BETWEEN :d1 AND :d2                
                GROUP BY c.name');
        $query->setParameters([
            'd1' => $fromDate,
            'd2' => $tillDate
        ]);

        return $query->getResult();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
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
    public function findOneBySomeField($value): ?User
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
