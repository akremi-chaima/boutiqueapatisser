<?php

namespace App\Serializer\Format;

use App\DTO\Format\AddFormatDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class AddFormatDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new AddFormatDTO())
            ->setName($data['name'] ?? null)
            ->setPastryId($data['pastryId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === AddFormatDTO::class;
    }
}