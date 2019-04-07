<?php

namespace App\Twig;

use App\ContextStorage;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AgencyExtension extends AbstractExtension
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

    public function getFunctions(): array
    {
        return [
            new TwigFunction('context_agency', [$this->contextStorage, 'getAgency']),
        ];
    }
}
