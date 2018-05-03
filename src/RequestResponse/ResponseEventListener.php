<?php
namespace App\RequestResponse;

use App\Response\Response;
use App\ViewHandler\HtmlViewHandler;
use App\ViewHandler\JSONViewHandler;
use App\ViewHandler\ViewHandler;
use App\ViewHandler\XMLViewHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class ResponseEventListener
{
    /**
     * @var XMLViewHandler
     */
    private $xmlViewHandler;
    /**
     * @var JSONViewHandler
     */
    private $jsonViewHandler;
    /**
     * @var HtmlViewHandler
     */
    private $htmlViewHandler;

    public function __construct(XMLViewHandler $xmlViewHandler, JSONViewHandler $jsonViewHandler, HtmlViewHandler $htmlViewHandler)
    {
        $this->xmlViewHandler = $xmlViewHandler;
        $this->jsonViewHandler = $jsonViewHandler;
        $this->htmlViewHandler = $htmlViewHandler;
    }

    public function getViewHandler(Request $request): ?ViewHandler
    {
        foreach ($request->getAcceptableContentTypes() as $contentType) {
            switch ($contentType) {
                case 'text/html':
                    return $this->htmlViewHandler;
                case 'application/xml':
                    return $this->xmlViewHandler;
                case 'application/json':
                    return $this->jsonViewHandler;
            }
        }
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        if (!$event->getControllerResult() instanceof Response) {
            return;
        }

        $viewHandler = $this->getViewHandler($event->getRequest());

        if (isset($viewHandler)) {
            $event->setResponse($viewHandler->convertToSymfonyResponse($event->getControllerResult()));
        }

    }

}