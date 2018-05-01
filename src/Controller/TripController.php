<?php


namespace App\Controller;


use App\Entity\Trip;
use App\Request\AddTripRequest;
use App\Response\CreatedResponse;
use App\Response\TripListResponse;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends Controller
{
    /**
     * @Route("/trips", methods={"GET"})
     */
    public function listTrips()
    {
        return TripListResponse::createFromTripArray($this->getTripRepository()->findAll());
    }

    /**
     * @Route("/trips", methods={"POST"})
     */
    public function addTrip(AddTripRequest $request)
    {
        $entityManager = $this->getTripsEntityManager();

        $newTrip = new Trip();
        $newTrip->setName($request->name);
        $newTrip->setStart($request->start);
        $newTrip->setEnd($request->end);

        $entityManager->persist($newTrip);
        $entityManager->flush();
        
        return new CreatedResponse($newTrip);
    }

    /**
     * @return ObjectRepository
     */
    private function getTripRepository()
    {
        return $this->getDoctrine()->getRepository(Trip::class);
    }

    /**
     * @return ObjectManager
     */
    private function getTripsEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

}