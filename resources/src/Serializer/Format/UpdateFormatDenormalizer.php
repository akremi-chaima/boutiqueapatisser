<?php

namespace App\Serializer\Format;

use App\DTO\Format\UpdateFormatDTO;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UpdateFormatDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return (new UpdateFormatDTO())
            ->setId($data['id'] ?? null)
            ->setName($data['name'] ?? null)
            ->setPastryId($data['pastryId'] ?? null);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === UpdateFormatDTO::class;
    }
}