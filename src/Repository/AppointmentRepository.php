<?php

namespace App\Repository;

use App\Entity\Appointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<Appointment>
 *
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }
    public function add(Appointment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function remove(Appointment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @return Appointment[] Returns an array of Appointment objects
     */
    public function findBy1($value): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.doctor = :val and a.state = :val1')
            ->setParameter('val', $value)
            ->setParameter('val1', 'pending')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
      /**
     * @return Appointment[] Returns an array of Appointment objects
     */
    public function findBy2($value): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.doctor = :val and a.state != :val1')
            ->setParameter('val', $value)
            ->setParameter('val1', 'pending')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
      /**
     * @return Appointment[] Returns an array of Appointment objects
     */
    public function findBy3($value): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.patient = :val and a.state = :val1')
            ->setParameter('val', $value)
            ->setParameter('val1', 'pending')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
      /**
     * @return Appointment[] Returns an array of Appointment objects
     */
    public function findBy4($value): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.patient= :val and a.state != :val1')
            ->setParameter('val', $value)
            ->setParameter('val1', 'pending')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Appointment
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
