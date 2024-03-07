<?php

namespace App\Controller\Address;

use App\DTO\Address\UpdateAddressDTO;
use App\Manager\AddressManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateAddressController extends AbstractController
{


    /* @var AddressManager */
    private $addressManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param UserManager $userManager
     * @param AddressManager $addressManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserManager $userManager,
        AddressManager $addressManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->userManager = $userManager;
        $this->addressManager = $addressManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update collection
     *
     * @Route("/api/update/address", methods={"PUT"})
     *
     * @OA\Tag(name="Addresses")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "city", "zipCode", "street"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="city", type="string"),
     *              @OA\Property(property="zipCode", type="string"),
     *              @OA\Property(property="street", type="string"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Address updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateAddressDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateAddressDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $address = $this->addressManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($address)) {
            return new JsonResponse(['error_message' => 'The address is not found'], Response::HTTP_BAD_REQUEST);
        }

        $address->setCity($dto->getCity())
            ->setZipCode($dto->getZipCode())
            ->setStreet($dto->getStreet());

        $this->addressManager->save($address);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}