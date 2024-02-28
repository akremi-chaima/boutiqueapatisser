<?php

namespace App\Controller\Format;

use App\DTO\Format\UpdateFormatDTO;
use App\Manager\FormatManager;
use App\Manager\PastryManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateFormatController extends AbstractController
{
    /* @var PastryManager */
    private $pastryManager;

    /* @var FormatManager */
    private $formatManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param PastryManager $pastryManager
     * @param FormatManager $formatManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        PastryManager $pastryManager,
        FormatManager $formatManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->pastryManager = $pastryManager;
        $this->formatManager = $formatManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update format
     *
     * @Route("/api/update/format", methods={"PUT"})
     *
     * @OA\Tag(name="Formats")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "name", "pastryId"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="pastryId", type="intger"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Format updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateFormatDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateFormatDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $pastry = $this->pastryManager->findOneBy(['id' => $dto->getPastryId()]);
        if (is_null($pastry)) {
            return new JsonResponse(['error_message' => 'The pastry is not found'], Response::HTTP_BAD_REQUEST);
        }

        $format= $this->formatManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($format)) {
            return new JsonResponse(['error_message' => 'The format is not found'], Response::HTTP_BAD_REQUEST);
        }

        $format->setName($dto->getName())
            ->setPastry($pastry);

        $this->formatManager->save($format);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}