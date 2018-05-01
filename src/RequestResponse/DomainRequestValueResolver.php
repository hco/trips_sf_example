<?php

namespace App\RequestResponse;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class DomainRequestValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Whether this resolver can resolve the value for the given ArgumentMetadata.
     *
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $this->isSupportedRequestArgument($argument) && $this->isSupportedRequestContentType($request);
    }

    /**
     * Returns the possible value(s).
     *
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return \Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $trip = $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
        yield $trip;
    }

    private function isSupportedRequestArgument(ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), \App\Request\Request::class);
    }

    private function isSupportedRequestContentType(Request $request): bool
    {
        return $request->getContentType() === 'json';
    }
}