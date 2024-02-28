<?php

namespace App\Serializer\Address;

use App\Entity\Address;
use App\Serializer\User\UserNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AddressNormalizer implements NormalizerInterface
{
    /** @var UserNormalizer $userNormalizer */
    private $userNormalizer;

    /**
     * @param UserNormalizer $userNormalizer
     */
    public function __construct(UserNormalizer $userNormalizer) {
        $this->userNormalizer = $userNormalizer;
    }
    /**
     * @param Address $address
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($address, string $format = null, array $context = [])
    {
        return [
            'id' => $address->getId(),
            'city' => $address->getCity(),
            'zipCode' => $address->getZipCode(),
            'street' => $address->getStreet(),
            'userId' => $this->userNormalizer->normalize($address->getUser())
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Address;
    }

}