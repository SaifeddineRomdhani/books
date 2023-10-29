<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function searchBookByRef($ref)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.ref = :ref')
            ->setParameter('ref', $ref)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function booksListByAuthors()
{
    return $this->createQueryBuilder('b')
        ->leftJoin('b.author', 'a')
        ->addSelect('a')
        ->orderBy('a.username', 'ASC')
        ->getQuery()
        ->getResult();
}

public function findBooksBefore2023WithAuthorHaving10Books()
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->join('b.author', 'a')
            ->where('b.publicationDate < :date')
            ->andWhere('a.nb_books > 10')
            ->setParameter('date', new \DateTime('2023-01-01'))
            ->orderBy('a.username', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
