<?php


namespace App\ViewHandler;


use App\Response\Response;

abstract class ViewHandler
{
    abstract public function convertToSymfonyResponse(Response $response): \Symfony\Component\HttpFoundation\Response;
}