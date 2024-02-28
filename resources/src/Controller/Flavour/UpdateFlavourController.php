<?php

namespace App\Controller\Flavour;

use App\DTO\Flavour\UpdateFlavourDTO;
use App\Manager\FlavourManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateFlavourController extends AbstractController
{
    /** @var FlavourManager  */
    private $flavourManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param FlavourManager $flavourManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        FlavourManager $flavourManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->flavourManager = $flavourManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update flavour
     *
     * @Route("/api/update/flavour", methods={"PUT"})
     *
     * @OA\Tag(name="Flavours")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "name", "isActive"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="isActive", type="boolean"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Flavour updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateFlavourDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateFlavourDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $flavour = $this->flavourManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($flavour)) {
            return new JsonResponse(['error_message' => 'The flavour is not found'], Response::HTTP_BAD_REQUEST);
        }

        $flavour->setName($dto->getName())
            ->setIsActive($dto->getIsActive());

        $this->flavourManager->save($flavour);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}