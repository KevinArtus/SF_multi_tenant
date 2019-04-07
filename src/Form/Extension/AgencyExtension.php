<?php

namespace App\Form\Extension;

use App\ContextStorage;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of AgencyExtension
 *
 * @author arnaud
 */
class AgencyExtension extends AbstractTypeExtension
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
    
    public function configureOptions(OptionsResolver $resolver)
    {
        if (!$this->contextStorage->getAgency()) {
            return;
        }
        
        $resolver->setDefault('agency', $this->contextStorage->getAgency());
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
