<?php namespace AppBundle\Listeners;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptionListener
{

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $path = $event->getRequest()->getPathInfo();

        if (strpos($path, '/api/') === 0)
        {
            $serializer = $this->container->get('jms_serializer');

            if($exception instanceof NotFoundHttpException){
                $status = Response::HTTP_NOT_FOUND;
            } else {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            $response = new JsonResponse(
                $serializer->serialize(
                    [
                        'error' => $exception->getMessage()
                    ],
                    'json'
                ),
                $status,
                [],
                true
            );

            $event->setResponse($response);
        };
    }
}