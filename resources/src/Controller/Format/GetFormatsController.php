<?php

namespace App\Controller\Format;

use App\Manager\FormatManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class GetFormatsController extends AbstractController
{
    /* @var FormatManager */
    private $formatManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param FormatManager $formatManager
     * @param SerializerInterface $serializer
     */
    public function __construct(FormatManager $formatManager, SerializerInterface $serializer)
    {
        $this->formatManager = $formatManager;
        $this->serializer = $serializer;
    }

    /**
     * Get formats list
     *
     * @Route("/api/formats", methods={"GET"})
     *
     * @OA\Tag(name="Formats")
     *
     * @OA\Response(response=200, description="Formats list")
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $formats = $this->formatManager->findAll();
        $normalizedList = $this->serializer->serialize($formats, 'json');
        return new JsonResponse(json_decode($normalizedList, true), Response::HTTP_OK);
    }

}