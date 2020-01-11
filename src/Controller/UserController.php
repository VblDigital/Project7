<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @Get(
     *     path = "/users/{clientId}",
     *     name = "view_users")
     */
    public function viewUsers(User $user = null, UserRepository $userRepository, SerializerInterface $serializer, $clientId)
    {
        $users = $userRepository->findAllUsers($clientId);
        $data = $serializer->serialize($users, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Rest\Get(
     *     path = "/user/{clientId}/{userId}",
     *     name = "view_user")
     * @param User|null $user
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param $clientId
     * @param $userId
     * @return Response
     */
    public function viewUser(User $user = null, UserRepository $userRepository, SerializerInterface $serializer,
            $clientId, $userId)
    {
        $user = $userRepository->findOneUser($clientId, $userId);
        $data = $serializer->serialize($user, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Rest\Post(
     *     path = "/newuser",
     *     name = "new_user")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ClientRepository $repository
     * @return User
     */
    public function newUser(Request $request, EntityManagerInterface $manager, ClientRepository $repository)
    {
        $data = json_decode($request->getContent(), true);

        $clientId = $data['client']['id'];
        $client = $repository->findClient($clientId);

        if ($client) {
            $user = new User();
            $user->createUserObject($data);
            $user->setClient($client[0]);

            $manager->persist($user);
            $manager->flush();

            return $user;
        }
    }

    /**
     * @Rest\Put(
     *     path = "/modifyuser/{userId}",
     *     name = "modify_user")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param ClientRepository $repository
     * @param UserRepository $userRepository
     * @return User
     */
    public function modifyUser(Request $request, EntityManagerInterface $manager, UserRepository $userRepository, $userId)
    {
        $data = json_decode($request->getContent(), true);

        $user = ($userRepository->findUser($userId))[0];

        if ($user){
            if($data['username']){
                $user->setUsername($data['username']);
            }
            if ($data['password']){
                $user->setPassword($data['password']);
            }
            if ($data['email']){
                $user->setEmail($data['email']);
            }

            $manager->persist($user);
            $manager->flush();

            return $user;
        }
    }
}