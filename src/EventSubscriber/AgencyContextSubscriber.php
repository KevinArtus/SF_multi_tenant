<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agency;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AgencyContextSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if(!$event->isMasterRequest()){

            return;
        }

        $agencySlug = $event->getRequest()->get('agency_slug');

        if(!$agencySlug){

            return;
        }

        $agency = $this->em->getRepository(Agency::class)->findOneBy(['slug'=>$agencySlug]);

        if(!$agency){
            throw new HttpException(404,'No agency found for slug '.$agencySlug);
        }

        $event->getRequest()->attributes->set('agency', $agency);

    }

    public static function getSubscribedEvents()
    {
        return [
           'kernel.request' => 'onKernelRequest',
        ];
    }
}
