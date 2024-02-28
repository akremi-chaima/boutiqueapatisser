<?php

namespace App\Serializer\Format;

use App\Entity\Format;
use App\Serializer\Pastry\PastryNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FormatNormalizer implements NormalizerInterface
{

    /** @var PastryNormalizer $pastryNormalizer */
    private $pastryNormalizer;

    /**
     * @param PastryNormalizer $pastryNormalizer
     */
    public function __construct(PastryNormalizer $pastryNormalizer) {
        $this->pastryNormalizer = $pastryNormalizer;
    }
    /**
     * @param Format $formatObject
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($formatObject, string $format = null, array $context = [])
    {
        return [
            'id' => $formatObject->getId(),
            'name' => $formatObject->getName(),
            'pastry' => $this->pastryNormalizer->normalize($formatObject->getPastry())

        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Format;
    }

}

