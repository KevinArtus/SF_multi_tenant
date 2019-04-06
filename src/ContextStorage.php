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
     * @var Agency
     */
    private $agency;

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(Agency $agency)
    {
        $this->agency = $agency;
    }

}
