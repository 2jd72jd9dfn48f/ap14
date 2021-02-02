<?php

namespace App\Repository;

use App\Entity\Tour;
use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeInterface;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Tour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tour[]    findAll()
 * @method Tour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, Tour::class);
        $this->manager = $manager;
    }

    public function saveTour($name, $image, $description, $date, $days, $price, $categoria)
    {
        $newTour = new Tour();

        $newTour
            ->setTitulo($name)
            ->setImagen($image)
            ->setDescription($description)
            ->setDays($days)
            ->setPrice($price);

        $this->manager->persist($newTour);
        $this->manager->flush();
    }

    public function updateTour(Tour $tour): Tour
    {
        $this->manager->persist($tour);
        $this->manager->flush();

        return $tour;
    }


    public function removeTour(Tour $tour)
    {
        $this->manager->remove($tour);
        $this->manager->flush();
    }

    /**
     * @return Tour[]
     */
    public function findAllWithCategory(int $num): array
    {
        $entityManager = $this->manager;

        $query = $entityManager->createQuery(
            'SELECT t
            FROM App\Entity\Tour t
            JOIN App\Entity\Categoria
            WHERE t.categoria_id = :id_categoria
            ORDER BY t.id ASC'
        )->setParameter('id_categoria', $num);

        return $query->getResult();
    }


/*     public function findByIdJoinedToCategory(Tour $tour): Tour
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT t FROM App\Entity\Tour t
            WHERE t.id IS NOT NULL
            ORDER BY t.id ASC'
        )->setParameter('id', 1);
            return $query->execute();
        } */


    // /**
    //  * @return Tour[] Returns an array of Tour objects
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
    public function findOneBySomeField($value): ?Tour
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