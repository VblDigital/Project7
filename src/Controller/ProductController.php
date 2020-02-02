<?php


namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Knp\Component\Pager\PaginatorInterface;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/products",
     *     name = "view_products")
     * @SWG\Response(
     *     response=200,
     *     description="Return the list of a available products",
     *     @Model(type=Product::class)
     * )
     * @SWG\Tag(name="Products")
     * @param ProductRepository $productRepository
     * @param Security $security
     * @param PaginatorInterface $pager
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function viewProducts(ProductRepository $productRepository, Security $security, PaginatorInterface $pager,
                                 Request $request, SerializerInterface $serializer)
    {
        $query = $productRepository->findAllProductsQuery($security->getUser()->getId());

        $paginated = $pager->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        $context = SerializationContext::create()->setGroups(array(
            'Default',
            'items' => array('detail')
        ));

        return new Response($serializer->serialize($paginated, 'json', $context));
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
