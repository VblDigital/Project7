<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

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
     *     path = "/newuser/{clientId}",
     *     name = "new_user")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param $clientId
     * @param ClientRepository $repository
     * @return View
     */
    public function newUser(User $user, EntityManagerInterface $manager, ValidatorInterface $validator, $clientId,
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

        return $this->view($user, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put(
     *     path = "/modifyuser/{userId}",
     *     name = "modify_user")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param $userId
     * @param UserRepository $repository
     * @return View
     */
    public function modifyUser(User $user, $userId, UserRepository $repository, EntityManagerInterface $manager)
    {
        $registredUser = $repository->findUser($userId);

        if(empty($registredUser)){
            return new View('Cet utilisateur n\'existe pas', Response::HTTP_NOT_FOUND);
        }

        $registredUser=$registredUser[0];
        $registredUser
            ->setUsername($user->getUsername())
            ->setEmail($user->getEmail())
            ->setPassword($user->getPassword());

        $manager->persist($registredUser);
        $manager->flush();

        return $this->view($registredUser, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete(
     *     path = "/deleteuser/{userId}",
     *     name = "modify_user")
     * @param $userId
     * @param UserRepository $repository
     * @return View
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
