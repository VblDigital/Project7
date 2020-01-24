<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"detail", "list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"detail", "list"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"detail"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="client_ìd", referencedColumnName="id", nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * @param $client
     * @return $this
     */
    public function setClient ( $client)
    {
        $this->client = $client;
        return $this;
    }


    /**
     * @param array $data
     * @return void
     */
    function createUserObject(array $data)
    {
        $this->setUsername($data['username']);
        $this->setPassword($data['password']);
        $this->setEmail($data['email']);
    }
}
