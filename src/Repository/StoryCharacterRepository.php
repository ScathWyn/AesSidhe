<?php

namespace App\Repository;

use App\Entity\StoryCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StoryCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryCharacter[]    findAll()
 * @method StoryCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryCharacterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StoryCharacter::class);
    }

//    /**
//     * @return StoryCharacter[] Returns an array of StoryCharacter objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StoryCharacter
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
