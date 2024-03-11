<?php
namespace App\Serializer\Pastry;

use App\Entity\Format;
use App\Entity\Pastry;
use App\Manager\FormatManager;
use App\Serializer\Category\CategoryNormalizer;
use App\Serializer\Flavour\FlavourNormalizer;
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

    /** @var FormatManager */
    private $formatManager;

    public function __construct(
        SubCollectionNormalizer $subCollectionNormalizer,
        FlavourNormalizer $flavourNormalizer,
        CategoryNormalizer $categoryNormalizer,
        FormatManager $formatManager
    )
    {
        $this->subCollectionNormalizer = $subCollectionNormalizer;
        $this->flavourNormalizer = $flavourNormalizer;
        $this->categoryNormalizer = $categoryNormalizer;
        $this->formatManager = $formatManager;

    }

    /**
     * @param Pastry $pastry
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($pastry, string $format = null, array $context = [])
    {
        /** @var Format[] $formatsList */
        $formatsList = $this->formatManager->findBy(['pastry' => $pastry]);
        $formats = [];
        foreach ($formatsList as $format){
            $formats[] = $format->getName();
        }

        return [
            'id' => $pastry->getId(),
            'name' => $pastry->getName(),
            'price' => $pastry->getPrice(),
            'description' => $pastry->getDescription(),
            'isVisible' => $pastry->isVisible(),
            'flavour' => $this->flavourNormalizer->normalize($pastry->getFlavour()),
            'category' => $this->categoryNormalizer->normalize($pastry->getCategory()),
            'subCollection' => $this->subCollectionNormalizer->normalize($pastry->getSubCollection()),
            'picture' => '/uploads/'.$pastry->getId().'/'.$pastry->getPicture(),
            'formats' => $formats,
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Pastry;
    }

}

