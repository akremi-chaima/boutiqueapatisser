<?php

namespace App\Controller\User;

use App\DTO\SubCollection\UpdateSubCollectionDTO;
use App\DTO\User\UpdateUserDTO;
use App\Manager\CollectionManager;
use App\Manager\RoleManager;
use App\Manager\SubCollectionManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateUserController extends AbstractController
{
    /* @var UserManager */
    private $userManager;

    /* @var RoleManager */
    private $roleManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param UserManager $userManager
     * @param RoleManager $roleManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        UserManager $userManager,
        RoleManager $roleManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->userManager = $userManager;
        $this->roleManager = $roleManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update collection
     *
     * @Route("/api/update/user", methods={"PUT"})
     *
     * @OA\Tag(name="Users")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "firstName", "lastName", "password", "email"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="firstName", type="string"),
     *              @OA\Property(property="lastName", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="roleId", type="intger"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Collection updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
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

        $role = $this->roleManager->findOneBy(['id' => $dto->getRoleId()]);
        if (is_null($role)) {
            return new JsonResponse(['error_message' => 'The role is not found'], Response::HTTP_BAD_REQUEST);
        }
        $user = $this->userManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($user)) {
            return new JsonResponse(['error_message' => 'The subCollection is not found'], Response::HTTP_BAD_REQUEST);
        }

        $user->setFirstName($dto->getFirstName())
            ->setLastName($dto->getLastName())
            ->setPassword($dto->getPassword())
            ->setEmail($dto->getEmail())
            ->setRole($role);

        $this->userManager->save($user);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}