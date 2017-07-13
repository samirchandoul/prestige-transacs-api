<?php

namespace CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ApiResponseListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        if ($responseData = json_decode($response->getContent(), true)) {
            if (array_key_exists('_code', $responseData)) {
                $event->getResponse()->setStatusCode(200);
            }
        }
    }
}
