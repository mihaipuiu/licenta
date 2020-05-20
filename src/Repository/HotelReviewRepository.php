<?php

namespace App\Repository;

use App\Entity\HotelReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HotelReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method HotelReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method HotelReview[]    findAll()
 * @method HotelReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HotelReview::class);
    }
}
