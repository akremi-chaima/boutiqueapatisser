<?php

namespace App\Controller\Role;

use App\DTO\Role\UpdateRoleDTO;
use App\Manager\RoleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateRoleController extends AbstractController
{
    /* @var RoleManager */
    private $roleManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param RoleManager $roleManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        RoleManager $roleManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->roleManager = $roleManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Update collection
     *
     * @Route("/api/update/role", methods={"PUT"})
     *
     * @OA\Tag(name="Roles")
     *
     * * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"id", "name", "code"},
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="code", type="string"),
     *
     *          )
     *      )
     * )
     *
     * @OA\Response(response=200, description="Role updated")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var UpdateRoleDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), UpdateRoleDTO::class, 'json');

        $errors = $this->validator->validate($dto);

        if ($errors->count()) {
            $display = [];
            foreach ($errors as $error) {
                $display[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['error_messages' => $display], Response::HTTP_BAD_REQUEST);
        }

        $category = $this->roleManager->findOneBy(['id' => $dto->getId()]);
        if (is_null($category)) {
            return new JsonResponse(['error_message' => 'The role is not found'], Response::HTTP_BAD_REQUEST);
        }

        $category->setName($dto->getName())
            ->setCode($dto->getCode());

        $this->roleManager->save($category);
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

}