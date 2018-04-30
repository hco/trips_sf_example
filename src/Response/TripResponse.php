<?php


namespace App\Response;


use App\Entity\Trip;

class TripResponse
{
    public $id;
    public $name;
    public $start;
    public $end;

    public static function createFromEntity(Trip $trip): TripResponse
    {
        $response = new TripResponse();

        $response->id = $trip->getId();
        $response->name = $trip->getName();
        $response->start = $trip->getStart();
        $response->end = $trip->getEnd();

        return $response;
    }
}