<?php
namespace App\Serializer\Pastry;

use App\Entity\Pastry;
use App\Serializer\Category\CategoryNormalizer;
use App\Serializer\Flavour\FlavourNormalizer;
use App\Serializer\Picture\PictureNormalizer;
use App\Serializer\SubCollection\SubCollectionNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PastryNormalizer  implements NormalizerInterface
{

    /** @var SubCollectionNormalizer $subCollectionNormalizer */
    private $subCollectionNormalizer;


    /** @var FlavourNormalizer $flavourNormalizer */
    private $flavourNormalizer;

    /** @var CategoryNormalizer $categoryNormalizer */
    private $categoryNormalizer;

    /** @var PictureNormalizer $pictureNormalizer*/
    private $pictureNormalizer;

    public function __construct(
        SubCollectionNormalizer $subCollectionNormalizer,
        FlavourNormalizer $flavourNormalizer,
        CategoryNormalizer $categoryNormalizer,
        PictureNormalizer $pictureNormalizer,
    )
    {
        $this->subCollectionNormalizer = $subCollectionNormalizer;
        $this->flavourNormalizer = $flavourNormalizer;
        $this->categoryNormalizer = $categoryNormalizer;
        $this->pictureNormalizer = $pictureNormalizer;
    }

    /**
     * @param $pastry
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($pastry, string $format = null, array $context = [])
    {
        return [
            'id' => $pastry->getId(),
            'name' => $pastry->getName(),
            'price' => $pastry->getPrice(),
            'description' => $pastry->getDescription(),
            'isVisible' => $pastry->isVisible(),
            'flavour' => $this->flavourNormalizer->normalize($pastry->getFlavour()),
            'category' => $this->categoryNormalizer->normalize($pastry->getCategory()),
            'subCollection' => $this->subCollectionNormalizer->normalize($pastry->getSubCollection()),
            'pictures' => $pastry->getPicture(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Pastry;
    }

}
