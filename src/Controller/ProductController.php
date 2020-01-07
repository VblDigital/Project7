<?php


namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/products/17",
     *     name="view_product")
     */
    public function viewProducts(Product $product = null, ProductRepository $productRepository)
    {
        return $productRepository->findAllProducts('17');
    }
}