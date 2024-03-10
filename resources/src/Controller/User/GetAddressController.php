<?php

namespace App\Controller\User;

use App\Manager\AddressManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetAddressController extends AbstractController
{
    /* @var AddressManager */
    private $addressManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param AddressManager $addressManager
     * @param SerializerInterface $serializer
     */
    public function __construct(AddressManager $addressManager, SerializerInterface $serializer)
    {
        $this->addressManager = $addressManager;
        $this->serializer = $serializer;
    }

    /**
     * Get address
     *
     * @Route("/api/private/address", methods={"GET"})
     *
     * @OA\Tag(name="Addresses")
     *
     * @OA\Response(response=200, description="Address")
     *
     * @param UserInterface $user
     * @return JsonResponse
     */
    public function __invoke(UserInterface $user): JsonResponse
    {
        $address = $this->addressManager->findOneBy(['user' => $user]);
        if(is_null($address)){
            return new JsonResponse(['error_message' => 'The address is not found'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(json_decode($this->serializer->serialize($address, 'json'), true), Response::HTTP_OK);
    }
}