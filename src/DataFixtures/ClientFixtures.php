<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ClientFixtures
 * @package App\DataFixtures
 */
class ClientFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load( ObjectManager $manager)
    {
        $client = new Client();
        $client
            ->setName("Client type")
            ->setEmail('client1@client1.com')
            ->setRole('ROLE_CLIENT');
        $hash = password_hash('123456', PASSWORD_BCRYPT);
        $client->setPassword($hash);
        $manager->persist($client);
        $this->addReference('client1', $client);

        $manager->flush();
    }
}
