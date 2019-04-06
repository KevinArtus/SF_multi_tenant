<?php

namespace App;

use App\Entity\Agency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RequestContext;

/**
 *
 * @author arnaud
 */
class ContextStorage
{

    /**
     *
     * @var EntityManagerInterface
     */
    private $em;

    /**
     *
     * @var RequestContext
     */
    private $requestContext;

    /**
     *
     * @var Agency
     */
    private $agency;

    public function __construct(RequestContext $requestContext, EntityManagerInterface $em)
    {
        $this->requestContext = $requestContext;
        $this->em = $em;
    }

    public function activateContextBySlug($agencySlug)
    {
        $agency = $this->em->getRepository(Agency::class)->findOneBy(['slug' => $agencySlug]);

        if (!$agency) {
            throw new HttpException(404, 'No agency found for slug ' . $agencySlug);
        }

        $this->agency = $agency;

        $this->requestContext->setParameter('agency_slug', $agency->getSlug());

        return $agency;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

}
