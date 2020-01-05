<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @return array
     */
    public function getDependencies ()
    {
        return array(
            ClientFixtures::class);
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load( ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setName("Monsieur X")
            ->setEmail("user1@user.com")
            ->setClient($this->getReference('client1'));
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $user = new User();
        $user
            ->setName("Monsieur Y")
            ->setEmail("user2@user.com")
            ->setClient($this->getReference('client1'));
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $user = new User();
        $user
            ->setName("Monsieur Z")
            ->setEmail("user3@user.com")
            ->setClient($this->getReference('client1'));
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $user = new User();
        $user
            ->setName("Madame X")
            ->setEmail("user4@user.com")
            ->setClient($this->getReference('client1'));
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $user = new User();
        $user
            ->setName("Madame Y")
            ->setEmail("user5@user.com")
            ->setClient($this->getReference('client1'));
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $manager->persist($user);

        $manager->flush();
    }
}
