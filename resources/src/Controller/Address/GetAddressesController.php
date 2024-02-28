<?php

namespace App\Controller\Address;

use App\Manager\AddressManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetAddressesController extends AbstractController
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
     * Get addresses list
     *
     * @Route("/api/addresses", methods={"GET"})
     *
     * @OA\Tag(name="Addresses")
     *
     * @OA\Response(response=200, description="Addresses list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $addresses = $this->addressManager->findAll();
        $normalizedList = $this->serializer->serialize($addresses, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}