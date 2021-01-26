<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Entity\Tour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, Categoria::class);
        $this->manager = $manager;
    }

    public function saveCategoria($categoria)
    {
        $newCategoria = new Categoria();

        $newCategoria
            ->setCategoria($categoria);

        $this->manager->persist($newCategoria);
        $this->manager->flush();
    }

    public function updateCategoria(Categoria $categoria): Categoria
    {
        $this->manager->persist($categoria);
        $this->manager->flush();

        return $categoria;
    }


    public function removeCategoria(Categoria $categoria)
    {
        $this->manager->remove($categoria);
        $this->manager->flush();
    }

    // /**
    //  * @return Categoria[] Returns an array of Categoria objects
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
    public function findOneBySomeField($value): ?Categoria
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