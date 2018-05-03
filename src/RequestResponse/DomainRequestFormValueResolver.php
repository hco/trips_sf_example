<?php

namespace App\RequestResponse;

use App\Request\AddTripRequest;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DomainRequestFormValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var \Metadata\Driver\DriverInterface
     */
    private $metadataDriver;

    public function __construct(\Metadata\Driver\DriverInterface $metadataDriver)
    {
        $this->metadataDriver = $metadataDriver;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return $this->isSupportedRequestArgument($argument) && $this->isSupportedRequestContentType($request);
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $metadata = $this->metadataDriver->loadMetadataForClass(new \ReflectionClass($argument->getType()));
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $addTripRequest = $trip = new AddTripRequest();

        foreach ($request->request->getIterator() as $key => $value) {
            if (isset($metadata->propertyMetadata[$key])) {
                $value = $this->convertValueToType($value, $metadata->propertyMetadata[$key]->type);
            }
            $propertyAccessor->setValue($addTripRequest, $key, $value);
        }

        yield $trip;
    }

    private function isSupportedRequestArgument(ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), \App\Request\Request::class);
    }

    private function isSupportedRequestContentType(Request $request): bool
    {
        return $request->getContentType() === 'form';
    }

    private function convertValueToType($value, $type)
    {
        switch ($type['name']) {
            case 'DateTimeImmutable':
                return new \DateTimeImmutable($value);
            default:
                return $value;
        }
    }
}