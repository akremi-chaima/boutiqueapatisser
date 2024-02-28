<?php

namespace App\Serializer\SubCollection;

use App\Entity\SubCollection;
use App\Serializer\Collection\CollectionNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SubCollectionNormalizer implements NormalizerInterface
{

    /** @var CollectionNormalizer $collectionNormalizer */
    private $collectionNormalizer;

    /**
     * @param CollectionNormalizer $collectionNormalizer
     */
    public function __construct(CollectionNormalizer $collectionNormalizer) {
        $this->collectionNormalizer = $collectionNormalizer;
    }
    /**
     * @param SubCollection $subCollection
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($subCollection, string $format = null, array $context = [])
    {
        return [
            'id' => $subCollection->getId(),
            'name' => $subCollection->getName(),
            'isActive' => $subCollection->isActive(),
            'collection' => $this->collectionNormalizer->normalize($subCollection->getCollection())

        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof SubCollection;
    }

}

