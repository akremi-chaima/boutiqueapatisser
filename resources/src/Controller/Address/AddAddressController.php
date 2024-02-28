<?php

namespace App\Controller\Address;

use App\DTO\Address\AddAddressDTO;
use App\DTO\User\AddUserDTO;
use App\Entity\Address;
use App\Entity\User;
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

class AddAddressController extends AbstractController
{
    /* @var UserManager */
    private $userManager;

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
     * @Route("/api/add/address", methods={"POST"})
     *
     * @OA\Tag(name="Addresses")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"city", "zipCode", "street", "userId"},
     *              @OA\Property(property="city", type="string"),
     *              @OA\Property(property="zipCode", type="string"),
     *              @OA\Property(property="street", type="string"),
     *              @OA\Property(property="userId", type="intger"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Address added")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var AddAddressDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), AddAddressDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        // validate user
        $user = $this->userManager->findOneBy(['id' => $dto->getUserId()]);
        if (is_null($user)) {
            return new JsonResponse(['error_message' => 'The user is not found'], Response::HTTP_BAD_REQUEST);
        }

        $address = (new Address())
            ->setCity($dto->getCity())
            ->setZipCode($dto->getZipCode())
            ->setStreet($dto->getStreet())
            ->setUser($user);

        $this->addressManager->save($address);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);

    }

}