<?php


namespace App\Controller;


use App\Entity\Trip;
use App\PersistenceLayer\TripPersistenceLayer;
use App\Request\AddTripRequest;
use App\Response\CreatedResponse;
use App\Response\TripListResponse;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TripController
{
    /**
     * @var TripPersistenceLayer
     */
    private $persistenceLayer;

    public function __construct(TripPersistenceLayer $persistenceLayer)
    {
        $this->persistenceLayer = $persistenceLayer;
    }

    /**
     * @Route("/trips", methods={"GET"})
     */
    public function listTrips()
    {
        return TripListResponse::createFromTripArray($this->persistenceLayer->getAllTrips());
    }

    /**
     * @Route("/trips", methods={"POST"})
     */
    public function addTrip(AddTripRequest $request)
    {
        $newTrip = new Trip();
        $newTrip->setName($request->name);
        $newTrip->setStart($request->start);
        $newTrip->setEnd($request->end);

        $this->persistenceLayer->persist($newTrip);

        return new CreatedResponse($newTrip);
    }
}