<?php


namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/products/{clientId}",
     *     name = "view_products")
     */
    public function viewProducts(Product $product = null, ProductRepository $productRepository,
         SerializerInterface $serializer, $clientId)
    {
        $products = $productRepository->findAllProducts($clientId);
        $data = $serializer->serialize($products, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Get(
     *     path = "/product/{clientId}/{productId}",
     *     name = "view_product")
     */
    public function viewProduct(Product $product = null, ProductRepository $productRepository,
         SerializerInterface $serializer, $clientId, $productId)
    {
        $product = $productRepository->findOneProduct($clientId, $productId);
        $data = $serializer->serialize($product, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
