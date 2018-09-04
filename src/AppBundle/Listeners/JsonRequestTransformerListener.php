<?php

namespace AppBundle\Listeners;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class JsonRequestTransformerListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getContentType() !== 'json') {
            return;
        }

        $content = $request->getContent();

        if (empty($content)) {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if ($data) {
            $request->request->replace($data);
        }
    }
}
