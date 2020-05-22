<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    public function findHotelsByFilters(
        string $name = '',
        int $minPrice = 0,
        int $maxPrice = 99999,
        float $minRating = 0.0,
        int $guests = 0
    )
    {
        $qb = $this->createQueryBuilder('h');
        $qb->leftJoin('h.city', 'c');
        $qb->leftJoin('h.reviews', 'rev');
        $qb->leftJoin('h.rooms', 'roo');
        $qb->leftJoin('roo.roomOccupations', 'roc');

        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('h.name', ':name'),
                        $qb->expr()->like('c.name', ':name')
                    ),
                    $qb->expr()->andX(
                        $qb->expr()->between('roo.price', ':minPrice', ':maxPrice')
                    ),
                    $qb->expr()->andX(
                        $qb->expr()->gte('h.overallRating', ':minRating')
                    )
                )
            )
            ->setParameter('name', '%'.$name.'%')
            ->setParameter('minPrice', $minPrice)
            ->setParameter('maxPrice', $maxPrice)
            ->setParameter('minRating', $minRating);

        if(!empty($guests)) {
            $qb->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->gte('roo.maxGuests', ':guests')
                )
            )
            ->setParameter('guests', $guests);
        }

        $qb->distinct();

        return $qb->getQuery()->getResult();
    }
}
