<?php

namespace App\Serializer\Order;

use App\DTO\Order\AddOrderContentDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddOrderContentDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddOrderContentDTO())
            ->setQuantity($data['quantity'] ?? null)
            ->setPastryId($data['pastryId'] ?? null)
            ->setFormatName($data['formatName'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddOrderContentDTO::class;
    }
}