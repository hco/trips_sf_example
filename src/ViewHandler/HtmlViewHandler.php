<?php


namespace App\ViewHandler;


use App\Response\Response;

class HtmlViewHandler extends ViewHandler
{
    /**
     * @var \JMS\Serializer\SerializerInterface
     */
    protected $serializer;
    /**
     * @var \Twig\Environment
     */
    private $twig;

    public function __construct(\Twig\Environment $twig)
    {
        $this->twig = $twig;
    }

    public function convertToSymfonyResponse(Response $response): \Symfony\Component\HttpFoundation\Response
    {
        $httpResponse = new \Symfony\Component\HttpFoundation\Response(
            $this->getHtmlForResponse($response)
        );
        $httpResponse->headers->set('Content-Type', 'text/html');

        return $httpResponse;
    }

    public function getHtmlForResponse(Response $response)
    {
        $templateFile = $this->getTemplatePathForResponse($response);

        if (!$this->twig->getLoader()->exists($templateFile)) {
            return sprintf(
                '<!-- missing template for <%s> -->',
                get_class($response)
            );
        }

        return $this->twig->render($templateFile, array('response' => $response));
    }


    private function getTemplatePathForResponse(Response $response)
    {
        $className = get_class($response);
        $classNameWithoutNamespace = substr($className, strlen('\\App'));
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $classNameWithoutNamespace);
        $filePathWithExtension = $filePath . '.html.twig';

        return $filePathWithExtension;
    }

}