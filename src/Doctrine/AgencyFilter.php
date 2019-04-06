<?php

namespace App\Doctrine;

use App\Model\AgencyRestrictableInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * Description of AgencyFilter
 *
 * @author arnaud
 */
class AgencyFilter extends SQLFilter
{

    //put your code here
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->implementsInterface(AgencyRestrictableInterface::class)) {
            
            return '';
        }

        return "$targetTableAlias.agency_id = " . $this->getParameter('agency_id');
    }

}
