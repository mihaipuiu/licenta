<?php

namespace App\Repository;

use App\Entity\HotelPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HotelPhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method HotelPhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method HotelPhoto[]    findAll()
 * @method HotelPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelPicturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HotelPhoto::class);
    }
}
