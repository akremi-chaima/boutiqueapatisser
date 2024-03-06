<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var UserPasswordHasherInterface */
    private $userPasswordHasherInterface;

    /**
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
        ['firstName' => 'chayma', 'lastName' => 'akermi', 'password' => 'abc123', 'email' => 'chayma.akermi1997@gmail.com', 'role' => 'admin', 'phoneNumber' => '0600000000'],
        ['firstName' => 'chaima', 'lastName' => 'akremi', 'password' => 'abc123', 'email' => 'chaima.akremi.1997@gmail.com', 'role' => 'client', 'phoneNumber' => '0600000000'],
    ];

        foreach ($users as $userDetails) {
            $user = (new User())
                ->setFirstName($userDetails['firstName'])
                ->setLastName($userDetails['lastName'])
                ->setEmail($userDetails['email'])
                ->setPhoneNumber($userDetails['phoneNumber'])
                ->setRole($this->getReference($userDetails['role']));
            $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, hash('sha256', $userDetails['password'])));
            $manager->persist($user);
            $this->addReference($userDetails['email'], $user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }
}
