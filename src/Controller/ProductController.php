<?php


namespace App\Controller;

use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/products",
     *     name = "view_products")
     * @View(serializerGroups={"list"})
     * @param ProductRepository $productRepository
     * @param Security $security
     * @return Response
     */
    public function viewProducts(ProductRepository $productRepository, Security $security)
    {
        return $productRepository->findAllProductsQuery($security->getUser()->getId());
    }
ha
    /**
     * @Get(
     *     path = "/products/{productId}",
     *     name = "view_product",
     *     requirements={"id"="\d+"}))
     * @View(serializerGroups={"detail"})
     * @param ProductRepository $productRepository
     * @param Security $security
     * @return Response
     */
    public function viewProduct($productId, ProductRepository $productRepository, Security $security)
    {
        return $productRepository->findOneProduct($security->getUser()->getId(), $productId);
    }
}
