<?php


namespace App\Controller;


use App\Entity\Trip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UsualController extends Controller
{

    /**
     * @Route("/tripz/{id}")
     */
    public function getTrips(Request $request)
    {
        $id = $request->attributes->get('id');

        $repository = $this->getDoctrine()->getRepository(Trip::class);
        $trip = $repository->find($id);

        return $this->render('trip.html.twig', ['trip' => $trip]);
    }

}