<?php

namespace App\Serializer\User;

use App\Entity\Address;
use App\Entity\User;
use App\Manager\AddressManager;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    /* @var AddressManager */
    private $addressManager;

    /**
     * @param AddressManager $addressManager
     */
    public function __construct(AddressManager $addressManager)
    {
        $this->addressManager = $addressManager;
    }

    /**
     * @param User $user
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($user, string $format = null, array $context = [])
    {
        /** @var Address|null $address */
        $address = $this->addressManager->findOneBy(['user' => $user]);

        return [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'phoneNumber' => $user->getPhoneNumber(),
            'role' => $user->getRoles()[0],
            'city' => $address->getCity(),
            'zipCode' => $address->getZipCode(),
            'street' => $address->getStreet()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof User;
    }
}