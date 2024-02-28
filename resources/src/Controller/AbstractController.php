<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractController
 * @package App\Controller
 */
abstract class AbstractController
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @param ValidatorInterface  $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @param int   $code
     *
     * @return JsonResponse
     */
    public function getResponse(array $data, int $code)
    {
        $response = new JsonResponse();
        $response->setStatusCode($code);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $response;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return array
     */
    public function displayValidationErrors(ConstraintViolationListInterface $errors)
    {
        $display = [];
        foreach ($errors as $error) {
            $display[$error->getPropertyPath()] = $error->getMessage();
        }

        return [
            'error_messages' => $display,
        ];
    }


}