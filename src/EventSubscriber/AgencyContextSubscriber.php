<?php

namespace App\EventSubscriber;

use App\ContextStorage;
use App\Entity\Agency;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AgencyContextSubscriber implements EventSubscriberInterface
{

    /**
     *
     * @var ContextStorage
     */
    private $contextStorage;

    public function __construct(ContextStorage $contextStorage)
    {
        $this->contextStorage = $contextStorage;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {

            return;
        }

        $agencySlug = $event->getRequest()->get('agency_slug');

        if (!$agencySlug) {

            return;
        }

        $agency = $this->contextStorage->activateContextBySlug($agencySlug);

        $event->getRequest()->attributes->set('agency', $agency);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

}
