<?php


namespace App\Response;


use App\Entity\Trip;

class TripListResponse extends Response
{
    /**
     * @var TripResponse[]
     */
    public $trips = array();

    public static function createFromTripArray(array $trips): TripListResponse
    {
        $response = new TripListResponse();

        $response->trips = array_map(function (Trip $trip) {
            return TripResponse::createFromEntity($trip);
        }, $trips);

        return $response;
    }
}