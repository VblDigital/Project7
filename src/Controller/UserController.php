<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/users/{clientId}",
     *     name = "view_users")
     * @IsGranted("ROLE_CLIENT")
     */
    public function viewUsers(Request $request, User $user = null, UserRepository $userRepository, SerializerInterface $serializer,
                              $clientId, PaginatorInterface $pager)
    {
        $query = $userRepository->findAllUsersQuery($clientId);
        $paginated = $pager->paginate(
            $query,
            $request->query->getInt('page', 1), $request->query->getInt('limit', 10));

        $data = $serializer->serialize($paginated, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Rest\Get(
     *     path = "/users/{clientId}/{userId}",
     *     name = "view_user")
     * @param User|null $user
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param $clientId
     * @param $userId
     * @return Response
     * @IsGranted("ROLE_CLIENT")
     */
    public function viewUser(User $user = null, $clientId, $userId, UserRepository $userRepository, SerializerInterface $serializer)
    {
        $user = $userRepository->findOneUser($clientId, $userId);
        $data = $serializer->serialize($user, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post(
     *     path = "/users/{clientId}",
     *     name = "new_user")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @IsGranted("ROLE_CLIENT")
     */
    public function newUser(User $user, $clientId, EntityManagerInterface $manager, ValidatorInterface $validator,
                            ClientRepository $repository)
    {
        $client = $repository->findClient($clientId);
        $user->setClient($client[0]);

        $validatorResults = $validator->validate($user, null, null);
        if(count($validatorResults) > 0){
            return $this->view($validatorResults, Response::HTTP_BAD_REQUEST);
        }

        $manager->persist($user);
        $manager->flush();

        return $user;
    }

    /**
     * @Rest\Put(
     *     path = "/users/{userId}",
     *     name = "modify_user")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param $userId
     * @param UserRepository $repository
     * @return View
     * @IsGranted("ROLE_CLIENT")
     */
    public function modifyUser(User $user, $userId, UserRepository $repository, EntityManagerInterface $manager)
    {
        $registeredUser = $repository->findUser($userId);

        if(empty($registeredUser)){
            return new View('Cet utilisateur n\'existe pas', Response::HTTP_NOT_FOUND);
        }

        $registeredUser=$registeredUser[0];
        $registeredUser
            ->setUsername($user->getUsername())
            ->setEmail($user->getEmail())
            ->setPassword($user->getPassword());

        $manager->persist($registeredUser);
        $manager->flush();

        return $this->view($registeredUser, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete(
     *     path = "/users/{userId}",
     *     name = "delete_user")
     * @param $userId
     * @param UserRepository $repository
     * @return View
     * @IsGranted("ROLE_CLIENT")
     */
    public function deleteUser($userId, UserRepository $repository, EntityManagerInterface $manager)
    {
        $registredUser = $repository->findUser($userId);

        if(empty($registredUser)){
            return new View('Cet utilisateur n\'existe pas', Response::HTTP_NOT_FOUND);
        }

        $registredUser = $registredUser[0];
        $manager->remove($registredUser);
        $manager->flush();

        return new View('L\'utilisateur a été supprimé');
    }
}
