<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\ORM\NonUniqueResultException;


/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * @param $clientId
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findClient($clientId)
    {
        $query = $this->createQueryBuilder('client')
            ->where('client.id = :clientId')
            ->setParameters(array('clientId' => $clientId));

        try {
            return $results = $query->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            throw new HttpException(400);
        }
    }
}
