<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $clientId
     * @return mixed
     */
    public function findAllUsersQuery($clientId)
    {
        $query = $query = $this->createQueryBuilder('user')
            ->where('user.client = :clientId')
            ->setParameter('clientId', $clientId);

        $results = $query->getQuery()->getResult();

        if (empty($results)){
            throw new HttpException(204);
        }

        return $results;
    }

    /**
     * @param $clientId
     * @param $userId
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findOneUser($clientId, $userId)
    {
        $query = $this->createQueryBuilder('user')
            ->where('user.client = :clientId')
            ->andWhere('user.id = :userId')
            ->setParameters(array('clientId' => $clientId, 'userId' => $userId));

        return $results = $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $userId
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findUser($userId)
    {
        $query = $this->createQueryBuilder('user')
            ->where('user.id = :userId')
            ->setParameters(array('userId' => $userId));

        return $results = $query->getQuery()->getOneOrNullResult();
    }
}
