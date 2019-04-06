<?php

namespace App\EventSubscriber;

use App\ContextStorage;
use App\Entity\Agency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AgencyContextSubscriber implements EventSubscriberInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     *
     * @var ContextStorage
     */
    private $contextStorage;

    public function __construct(EntityManagerInterface $em, ContextStorage $contextStorage)
    {
        $this->em = $em;
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

        $agency = $this->em->getRepository(Agency::class)->findOneBy(['slug' => $agencySlug]);

        if (!$agency) {
            throw new HttpException(404, 'No agency found for slug ' . $agencySlug);
        }

        $event->getRequest()->attributes->set('agency', $agency);
        
        $this->contextStorage->setAgency($agency);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

}
