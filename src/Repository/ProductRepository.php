<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Parameter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param $clientId
     * @return mixed
     */
    public function findAllProductsQuery($clientId)
    {
        $query = $this->createQueryBuilder('product')
            ->leftJoin('product.clients', 'c')
            ->where('c.id = :clientId')
            ->setParameter('clientId', $clientId);

        return $query;
    }

    /**
     * @param $clientId
     * @param $productId
     * @return mixed
     */
    public function findOneProduct($clientId, $productId)
    {
        $query = $this->createQueryBuilder('product')
            ->leftJoin('product.clients', 'c')
            ->where('c.id = :clientId')
            ->andWhere('product.id = :productId')
            ->setParameters(array('clientId' => $clientId, 'productId' => $productId));

        return $query;
    }
}
