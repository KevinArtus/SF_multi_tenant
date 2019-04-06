<?php

namespace App\Model;

use App\Entity\Agency;

/**
 *
 * @author arnaud
 */
interface AgencyRestrictableInterface
{
    public function getAgency():Agency;
}
