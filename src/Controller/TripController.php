<?php


namespace App\Controller;


use App\Entity\Trip;
use App\Response\TripListResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends Controller
{
    /**
     * @Route("/foo", methods={"GET"})
     */
    public function listTrips()
    {
        return TripListResponse::createFromTripArray($this->getDoctrine()->getRepository(Trip::class)->findAll());
    }
}