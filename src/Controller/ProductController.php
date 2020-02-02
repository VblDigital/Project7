<?php


namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/products",
     *     name = "view_products")
     * @View(serializerGroups={"list"})
     * @SWG\Response(
     *     response=200,
     *     description="Return the list of a available products",
     *     @Model(type=Product::class)
     * )
     * @SWG\Tag(name="Products")
     * @param ProductRepository $productRepository
     * @param Security $security
     * @return Response
     */
    public function viewProducts(ProductRepository $productRepository, Security $security)
    {
        return $productRepository->findAllProductsQuery($security->getUser()->getId());
    }

    /**
     * @Get(
     *     path = "/products/{productId}",
     *     name = "view_product",
     *     requirements={"id"="\d+"}))
     * @View(serializerGroups={"detail"})
     * @SWG\Response(
     *     response=200,
     *     description="Return the details of a product",
     *     @Model(type=Product::class)
     * )
     * @SWG\Tag(name="Products")
     * @param ProductRepository $productRepository
     * @param Security $security
     * @return Response
     */
    public function viewProduct($productId, ProductRepository $productRepository, Security $security)
    {
        return $productRepository->findOneProduct($security->getUser()->getId(), $productId);
    }
}
