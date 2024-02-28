<?php

namespace App\Controller\Role;

use App\Manager\RoleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetRolesController extends AbstractController
{
    /* @var RoleManager */
    private $roleManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param RoleManager $roleManager
     * @param SerializerInterface $serializer
     */
    public function __construct(RoleManager $roleManager, SerializerInterface $serializer)
    {
        $this->roleManager = $roleManager;
        $this->serializer = $serializer;
    }

    /**
     * Get roles list
     *
     * @Route("/api/roles", methods={"GET"})
     *
     * @OA\Tag(name="Roles")
     *
     * @OA\Response(response=200, description="Roles list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $roles = $this->roleManager->findAll();
        $normalizedList = $this->serializer->serialize($roles, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}