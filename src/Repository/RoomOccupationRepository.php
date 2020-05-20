<?php

namespace App\Repository;

use App\Entity\RoomOccupation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoomOccupation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomOccupation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomOccupation[]    findAll()
 * @method RoomOccupation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomOccupationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomOccupation::class);
    }
}
