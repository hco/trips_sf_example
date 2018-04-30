<?php


namespace App\RequestResponse;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class ResponseEventListener
{

    public function __construct()
    {
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $value = $event->getControllerResult();
//        var_dump($value);
//        die();
        $response = new Response("Here I am");

        $event->setResponse($response);
    }

}