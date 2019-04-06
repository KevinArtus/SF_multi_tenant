<?php

namespace App\Entity;

use App\Model\AgencyRestrictableInterface;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository")
 */
class Contract implements AgencyRestrictableInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Agency")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agency;

    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        if($client && $client->getAgency()!==$this->getAgency()){
            throw new Exception('Invalid Client provided');
        }
        
        $this->client = $client;

        return $this;
    }

    public function getAgency():Agency
    {
        return $this->agency;
    }

}
