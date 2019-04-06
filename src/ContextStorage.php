<?php

namespace App;

use App\Entity\Agency;

/**
 *
 * @author arnaud
 */
class ContextStorage
{

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

    public function __construct(RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(Agency $agency)
    {
        $this->agency = $agency;
        
        $this->requestContext->setParameter('agency_slug', $agency->getSlug());
    }

}
