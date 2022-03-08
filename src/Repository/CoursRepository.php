<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Cours $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Cours $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Returns an array of all Cours objects at the given date.
     * @return Cours[] Returns an array of Cours objects
     */
    public function findByDate($date)
    {
        $date = new \DateTime($date);
        $dateDebut = \DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d 00:00:00'));
        $dateFin = \DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d 23:59:59'));
        return $this->createQueryBuilder('c')
            ->andWhere('c.dateHeureDebut >= :debut')
            ->andWhere('c.dateHeureDebut <= :fin')
            ->setParameter('debut', $dateDebut->format('Y-m-d H:i:s'))
            ->setParameter('fin', $dateFin->format('Y-m-d H:i:s'))
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Cours
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
