<?php


namespace App\Controller;


use App\Entity\Trip;
use App\PersistenceLayer\TripPersistenceLayer;
use App\Request\AddTripRequest;
use App\Response\CreatedResponse;
use App\Response\TripListResponse;
use App\Response\TripResponse;
use App\Service\TripExpensesCalculator;
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
    /**
     * @var TripExpensesCalculator
     */
    private $expensesCalculator;

    public function __construct(TripPersistenceLayer $persistenceLayer, TripExpensesCalculator $expensesCalculator)
    {
        $this->persistenceLayer = $persistenceLayer;
        $this->expensesCalculator = $expensesCalculator;
    }

    /**
     * @Route("/trips", methods={"GET"})
     */
    public function listTrips()
    {
        return TripListResponse::createFromTripArray($this->persistenceLayer->getAllTrips());
    }

    /**
     * @Route("/trips/{tripId}", methods={"GET"})
     */
    public function getTrip($tripId)
    {
        $trip = $this->persistenceLayer->getById($tripId);
        return TripResponse::createFromEntity($trip);
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
        $newTrip->setExpenses(
            $this->expensesCalculator->getExpenses(
                $request->start,
                $request->end
            )
        );

        $this->persistenceLayer->persist($newTrip);

        return new CreatedResponse($newTrip);
    }
}