<?php

namespace App\Repository;

use App\Entity\Contacto;
use App\Entity\Tour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Contacto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contacto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contacto[]    findAll()
 * @method Contacto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactoRepository extends ServiceEntityRepository 
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, Contacto::class);
        $this->manager = $manager;
    }

    public function saveContacto($contacto)
    {
        $newContacto = new Contacto();

        $newContacto
            ->setContacto($contacto);

        $this->manager->persist($newContacto);
        $this->manager->flush();
    }

    public function updateContacto(Contacto $contacto): Contacto
    {
        $this->manager->persist($contacto);
        $this->manager->flush();

        return $contacto;
    }


    public function removeContacto(Contacto $contacto)
    {
        $this->manager->remove($contacto);
        $this->manager->flush();
    }

       /**
    * @return Contacto[] Returns an array of Tour objects
    */ 
    public function findCosas(): array
    {
    
        $qb = $this->createQueryBuilder("a")
        ->where('a.date > :min')
        ->andWhere('a.date < :max')
        ->setParameter('min', '2020-12-01')
        ->setParameter('min', '2020-12-01');

        $query = $qb->getQuery();

        return $query->execute();
    }

    
    

    // /**
    //  * @return Contacto[] Returns an array of Contacto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contacto
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}