<?php
/**
 * Created by PhpStorm.
 * User: pdolinaj
 * Date: 11/09/18
 * Time: 15:19
 */
namespace App\EventListener;

use App\Api\ApiProblemException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $e = $event->getException();
        if (!$e instanceof ApiProblemException) {
            return;
        }
        $apiProblem = $e->getApiProblem();
        $response = new JsonResponse(
            $apiProblem->toArray(),
            $apiProblem->getStatusCode()
        );
        $response->headers->set('Content-Type', 'application/problem+json');
        $event->setResponse($response);
    }
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}