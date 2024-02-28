<?php

namespace App\Controller\Flavour;

use App\DTO\Flavour\AddFlavourDTO;
use App\DTO\Flavour\UpdateFlavourDTO;
use App\Entity\Flavour;
use App\Manager\FlavourManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddFlavourController extends AbstractController
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
     * Add flavour
     *
     * @Route("/api/add/flavour", methods={"POST"})
     *
     * @OA\Tag(name="Flavours")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"name", "isActive"},
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="isActive", type="boolean"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Flavour added")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var AddFlavourDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), AddFlavourDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $flavour =(new Flavour())
            ->setName($dto->getName())
            ->setIsActive($dto->getIsActive());

        $this->flavourManager->save($flavour);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}