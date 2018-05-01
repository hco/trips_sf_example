<?php

namespace App\Request;

use JMS\Serializer\Annotation as Serializer;

class AddTripRequest extends Request
{
    /**
     * @var string
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @var \DateTimeImmutable
     * @Serializer\Type("DateTimeImmutable")
     */
    public $start;

    /**
     * @var \DateTimeImmutable
     * @Serializer\Type("DateTimeImmutable")
     */
    public $end;
}