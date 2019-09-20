<?php declare(strict_types=1);

namespace App\Repositories;

use App\Entity\DummyEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * Class DummyEntityRepository
 *
 * @package   App\Repositories
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2019 RichCongress (https://www.richcongress.com)
 */
class DummyEntityRepository extends ServiceEntityRepository
{
    /**
     * DummyEntityRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DummyEntity::class);
    }

    /**
     * @param int $maximumNumber
     *
     * @return void
     */
    public function deleteOldOnes(int $maximumNumber): void
    {
        $qb = $this->createQueryBuilder('de');

        $idsArray = $qb->select('de.id')
            ->addOrderBy('de.id', 'ASC')
            ->getQuery()
            ->getScalarResult();

        $ids = \array_map(static function ($entry) {
            return (int) $entry['id'];
        }, $idsArray);
        $count = \sizeof($ids);

        if ($count < $maximumNumber) {
            return;
        }

        $qb = $this->createQueryBuilder('de');

        $qb->delete()
            ->where(
                $qb->expr()->in(
                    'de.id',
                    \array_slice($ids, 0, $count - $maximumNumber, true)
                )
            )
            ->getQuery()
            ->execute();
    }
}