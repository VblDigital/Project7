<?php


namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\GET; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;

class SecurityController extends AbstractController
{
    /**
     * @GET(name="login", path="/login_check")
     * @SWG\Response(
     *     response=200,
     *     description="Login's page for the client",
     * )
     * @SWG\Tag(name="Login")
     * @return JsonResponse
     */
    public function api_login(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse([
           'email' => $user->getEmail(),
           'roles' => $user->getRoles()
        ]);
    }
}