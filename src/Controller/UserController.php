<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends ObjectManagerController
{
    /**
     * @Rest\Get(
     *     path = "/users",
     *     name = "view_users")
     * @SWG\Response(
     *     response=200,
     *     description="Return the list of user",
     *     @Model(type=User::class)
     * )
     * @SWG\Tag(name="Users")
     * @IsGranted("ROLE_CLIENT")
     * @param UserRepository $userRepository
     * @param Security $security
     * @param PaginatorInterface $pager
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return Response
     * @throws InvalidArgumentException
     */
    public function viewUsers(UserRepository $userRepository, Security $security, PaginatorInterface $pager,
                              Request $request, SerializerInterface $serializer)
    {
        $key = 'user.all?page=' . $request->query->getInt('page', 1);

        $onCache = $this->adapter->getItem($key);

        if (true === $onCache->isHit()){
            $data = $onCache->get();
            return $data;
        }

        $query = $userRepository->findAllUsersQuery($security->getUser()->getId());

        $paginated = $pager->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)
        );

        $context = SerializationContext::create()->setGroups(array(
            'Default',
            'items' => array('detail')
        ));

        $data =  new Response($serializer->serialize($paginated, 'json', $context));
        $this->cache->saveItem($key, $data);

        return $data;
    }

    /**
     * @Rest\Get(
     *     path = "/users/{userId}",
     *     name = "view_user",
     *     requirements={"id"="\d+"})
     * @View(serializerGroups={"detail"})
     * @SWG\Response(
     *     response=200,
     *     description="Return the details for one user",
     *     @Model(type=User::class)
     * )
     * @SWG\Tag(name="Users")
     * @param $userId
     * @param UserRepository $userRepository
     * @param Security $security
     * @return Response
     * @throws InvalidArgumentException
     * @IsGranted("ROLE_CLIENT")
     */
    public function viewUser($userId, UserRepository $userRepository, Security $security)
    {
        $key = 'user.once';

        $onCache = $this->adapter->getItem($key);

        if (true === $onCache->isHit()){
            $data = $onCache->get();
            return $data;
        }

        $data = $userRepository->findOneUser($security->getUser()->getId(), $userId);
        $this->cache->saveItem($key, $data);

        return $data;
    }

    /**
     * @Rest\Post(
     *     path = "/users",
     *     name = "new_user")
     * @View(serializerGroups={"credentials"})
     * @SWG\Response(
     *     response=201,
     *     description="To add a new user",
     *     @Model(type=User::class)
     * )
     * @SWG\Tag(name="Users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @IsGranted("ROLE_CLIENT")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param ClientRepository $repository
     * @param Security $security
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     * @throws InvalidArgumentException
     */
    public function newUser(User $user, EntityManagerInterface $manager, ValidatorInterface $validator,
                            ClientRepository $repository, Security $security, Request $request)
    {
        $client = $repository->findClient($security->getUser()->getId());
        $user->setClient($client[0]);

        $validatorResults = $validator->validate($user, null, null);
        if(count($validatorResults) > 0){
            return $this->view($validatorResults, Response::HTTP_BAD_REQUEST);
        }

        $hash = password_hash($user->getPassword(), PASSWORD_BCRYPT);
        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();

        $keyAll = 'user.all?page=' . $request->query->getInt('page', 1);
        $keyOnce = 'user.once';

        $cacheAll = $this->adapter->getItem($keyAll);
        $cacheOnce = $this->adapter->getItem($keyOnce);

        if (true === $cacheAll->isHit()){
            $this->adapter->clear();
        } elseif (true === $cacheOnce->isHit()) {
            $this->adapter->clear();
        }

        return $this->view($user, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put(
     *     path = "/users/{userId}",
     *     name = "modify_user")
     * @View(serializerGroups={"credentials"}, statusCode="201")
     * @SWG\Response(
     *     response=201,
     *     description="To modify an user",
     *     @Model(type=User::class)
     * )
     * @SWG\Tag(name="Users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @param User $user
     * @param $userId
     * @param UserRepository $repository
     * @param EntityManagerInterface $manager
     * @IsGranted("ROLE_CLIENT")
     * @return \FOS\RestBundle\View\View
     * @throws InvalidArgumentException
     */
    public function modifyUser(User $user, $userId, UserRepository $repository, EntityManagerInterface $manager, Request $request)
    {
        $registeredUser = $repository->findUser($userId);

        if(empty($registeredUser)){
            return $this->view('Cet utilisateur n\'existe pas', Response::HTTP_NOT_FOUND);
        }

        $registeredUser = $registeredUser[0];
        $registeredUser
            ->setUsername($user->getUsername())
            ->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT))
            ->setEmail($user->getEmail());

        $manager->persist($registeredUser);
        $manager->flush();

        $keyAll = 'user.all?page=' . $request->query->getInt('page', 1);
        $keyOnce = 'user.once';

        $cacheAll = $this->adapter->getItem($keyAll);
        $cacheOnce = $this->adapter->getItem($keyOnce);

        if (true === $cacheAll->isHit()){
            $this->adapter->clear();
        } elseif (true === $cacheOnce->isHit()) {
            $this->adapter->clear();
        }

        return $this->view($registeredUser);
    }

    /**
     * @Rest\Delete(
     *     path = "/users/{userId}",
     *     name = "delete_user")
     * @View(serializerGroups={"credentials"}, statusCode="204")
     * @SWG\Response(
     *     response=204,
     *     description="To delete an user",
     *     @Model(type=User::class)
     * )
     * @SWG\Tag(name="Users")
     * @param $userId
     * @param UserRepository $repository
     * @param EntityManagerInterface $manager
     * @return \FOS\RestBundle\View\View
     * @throws InvalidArgumentException
     * @IsGranted("ROLE_CLIENT")
     */
    public function deleteUser($userId, UserRepository $repository, EntityManagerInterface $manager, Request $request)
    {
        $registeredUser = $repository->findUser($userId);

        if(empty($registeredUser)){

            return $this->view('Cet utilisateur n\'existe pas', Response::HTTP_NOT_FOUND);
        }

        $registeredUser = $registeredUser[0];
        $manager->remove($registeredUser);
        $manager->flush();

        $keyAll = 'user.all?page=' . $request->query->getInt('page', 1);
        $keyOnce = 'user.once';

        $cacheAll = $this->adapter->getItem($keyAll);
        $cacheOnce = $this->adapter->getItem($keyOnce);

        if (true === $cacheAll->isHit()){
            $this->adapter->clear();
        } elseif (true === $cacheOnce->isHit()) {
            $this->adapter->clear();
        }

        return $this->view('L\'utilisateur a été supprimé');
    }
}
