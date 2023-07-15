<?php

namespace App\Repository;

use App\Entity\SummerMatch;
use App\Entity\TeamSummerMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamSummerMatch>
 *
 * @method TeamSummerMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamSummerMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamSummerMatch[]    findAll()
 * @method TeamSummerMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamSummerMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamSummerMatch::class);
    }

    public function save(TeamSummerMatch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TeamSummerMatch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return TeamSummerMatch[] Returns an array of SummerMatch objects
     */

    public function findTeamsByMatchId(int $matchId)
    {
        return $this->createQueryBuilder('tsm')
            ->join('tsm.match', 'm')
            ->join('tsm.team', 't')
            ->where('m.id = :matchId')
            ->setParameter('matchId', $matchId)
            ->getQuery()
            ->getResult();
    }
}
