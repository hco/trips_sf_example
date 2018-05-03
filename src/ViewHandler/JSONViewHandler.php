<?php

namespace App\ViewHandler;

use App\Response\Response;

class JSONViewHandler extends ViewHandler
{
    /**
     * @var \JMS\Serializer\SerializerInterface
     */
    protected $serializer;

    public function __construct(
        \JMS\Serializer\SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function convertToSymfonyResponse(
        Response $response
    ): \Symfony\Component\HttpFoundation\Response
    {
        $httpResponse = new \Symfony\Component\HttpFoundation\Response(
            $this->serializer->serialize($response, 'json')
        );

        $httpResponse->headers->set(
            'Content-Type',
            'application/json'
        );

        return $httpResponse;
    }
}