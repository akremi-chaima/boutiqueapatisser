<?php

namespace App\Controller\Pastry;

use App\DTO\Pastry\AddPastryDTO;
use App\Entity\Format;
use App\Entity\Pastry;
use App\Manager\CategoryManager;
use App\Manager\FlavourManager;
use App\Manager\FormatManager;
use App\Manager\PastryManager;
use App\Manager\SubCollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddPastryController extends AbstractController
{
    /** @var FlavourManager  */
    private $flavourManager;

    /** @var CategoryManager */
    private $categoryManager;

    /** @var SubCollectionManager */
    private $subCollectionManager;

    /** @var PastryManager */
    private $pastryManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var FormatManager */
    private $formatManager;

    /**
     * @param FlavourManager $flavourManager
     * @param CategoryManager $categoryManager
     * @param SubCollectionManager $subCollectionManager
     * @param PastryManager $pastryManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param FormatManager $formatManager
     */
    public function __construct(
        FlavourManager $flavourManager,
        CategoryManager $categoryManager,
        SubCollectionManager $subCollectionManager,
        PastryManager $pastryManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        FormatManager $formatManager
    )
    {
        $this->flavourManager = $flavourManager;
        $this->categoryManager = $categoryManager;
        $this->subCollectionManager = $subCollectionManager;
        $this->pastryManager = $pastryManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->formatManager = $formatManager;
    }

    /**
     * Add pastry
     *
     * @Route("/api/add/pastry", methods={"POST"})
     *
     * @OA\Tag(name="Pastries")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              required={"name", "price", "descripion", "isVisible", "categoryId", "subCollectionId", "flavourId"},
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="price", type="float"),
     *              @OA\Property(property="descripion", type="string"),
     *              @OA\Property(property="isVisible", type="boolean"),
     *              @OA\Property(property="categoryId", type="integer"),
     *              @OA\Property(property="subCollectionId", type="integer"),
     *              @OA\Property(property="flavourId", type="integer"),
     *              @OA\Property(property="file", type="file"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Pastry added")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UploadedFile|null $file */
        $file = $request->files->get('file');

        /** @var AddPastryDTO $dto */
        $dto = $this->serializer->deserialize(json_encode($request->request->all()), AddPastryDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        // validate category
        $category = $this->categoryManager->findOneBy(['id' => $dto->getCategoryId()]);
        if (is_null($category)) {
            return new JsonResponse(['error_message' => 'The category is not found'], Response::HTTP_BAD_REQUEST);
        }

        // validate flavour
        $flavour = $this->flavourManager->findOneBy(['id' => $dto->getFlavourId()]);
        if (is_null($flavour)) {
            return new JsonResponse(['error_message' => 'The flavour is not found'], Response::HTTP_BAD_REQUEST);
        }

        // validate subCollection
        $subCollection = $this->subCollectionManager->findOneBy(['id' => $dto->getSubCollectionId()]);
        if (is_null($subCollection)) {
            return new JsonResponse(['error_message' => 'The subCollection is not found'], Response::HTTP_BAD_REQUEST);
        }

        $pastry = (new Pastry())
            ->setName($dto->getName())
            ->setPrice($dto->getPrice())
            ->setDescription($dto->getDescription())
            ->setIsVisible($dto->getIsVisible())
            ->setCategory($category)
            ->setSubCollection($subCollection)
            ->setFlavour($flavour)
            ->setPicture(!is_null($file) ? $file->getClientOriginalName() : null);

        $this->pastryManager->save($pastry);

        if (!empty($dto->getFormats())) {
            foreach ($dto->getFormats() as $format) {
                $newFormat = (new Format())
                    ->setName($format)
                    ->setPastry($pastry);
                $this->formatManager->save($newFormat);
            }
        }
        if (!is_null($file)) {
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$pastry->getId();
            $file->move($destination, $file->getClientOriginalName());
        }

        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}