<?php

namespace App\Controller\User;

use App\DTO\User\UpdateUserDTO;
use App\Entity\Address;
use App\Manager\AddressManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateUserController extends AbstractController
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
     * Update user
     *
     * @Route("/api/private/update/user", methods={"PUT"})
     *
     * @OA\Tag(name="Users")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"firstName", "lastName", "phoneNummber", "email", "city", "zipCode", "street"},
     *              @OA\Property(property="firstName", type="string"),
     *              @OA\Property(property="lastName", type="string"),
     *              @OA\Property(property="phoneNummber", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="city", type="string"),
     *              @OA\Property(property="zipCode", type="string"),
     *              @OA\Property(property="street", type="string"),
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="User updated")
     *
     * @param Request $request
     * @param UserInterface $user
     * @return JsonResponse
     */
    public function __invoke(Request $request, UserInterface $user): JsonResponse
    {
        /** @var UpdateUserDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateUserDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $connectedUser = $this->userManager->findOneBy(['id' => $user->getId()]);
        if (is_null($connectedUser)) {
            return new JsonResponse(['error_message' => 'The user is not found'], Response::HTTP_BAD_REQUEST);
        }

        $connectedUser->setFirstName($dto->getFirstName())
            ->setLastName($dto->getLastName())
            ->setEmail($dto->getEmail())
            ->setPhoneNumber($dto->getPhoneNumber());

        $this->userManager->save($connectedUser);

        /** @var Address|null $address */
        $address = $this->addressManager->findOneBy(['user' => $connectedUser]);
        if (is_null($address)) {
            return new JsonResponse(['error_message' => 'The address is not found'], Response::HTTP_BAD_REQUEST);
        }

        $address->setCity($dto->getCity())
            ->setStreet($dto->getStreet())
            ->setZipCode($dto->getZipCode());
        $this->addressManager->save($address);

        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}