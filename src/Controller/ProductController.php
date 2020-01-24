<?php


namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/products/{clientId}",
     *     name = "view_products")
     * @param Product|null $product
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @param $clientId
     * @param PaginatorInterface $pager
     * @param Request $request
     * @return Response
     */
    public function viewProducts(Request $request, Product $product = null, $clientId, ProductRepository $productRepository,
         SerializerInterface $serializer, PaginatorInterface $pager)
    {
        $query = $productRepository->findAllProductsQuery($clientId);
        $paginated = $pager->paginate(
            $query,
            $request->query->getInt('page', 1), $request->query->getInt('limit', 10));

        $data = $serializer->serialize(
            $paginated,
            'json',
            ['groups' => 'list']);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Get(
     *     path = "/products/{clientId}/{productId}",
     *     name = "view_product")
     * @param Product|null $product
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @param $clientId
     * @param $productId
     * @return Response
     */
    public function viewProduct(Product $product = null, $clientId, $productId, ProductRepository $productRepository,
         SerializerInterface $serializer)
    {
        $product = $productRepository->findOneProduct($clientId, $productId)->getQuery()->getResult();
        $data = $serializer->serialize(
            $product,
            'json',
            ['groups' => 'detail']);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
