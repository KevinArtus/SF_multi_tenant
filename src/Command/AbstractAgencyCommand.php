<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\ContextStorage;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Agency;
use Doctrine\ORM\EntityManager;

abstract class AbstractAgencyCommand extends Command
{
    /**
     * @var ContextStorage
     */
    private $contextStorage;

    /**
     * @var EntityManager
     */
    protected $em;



    protected static $defaultName = 'app:abstract';
    protected $property;

    public function __construct(ContextStorage $ct, EntityManagerInterface $em, $name = null)
    {
        $this->contextStorage = $ct;
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->addOption('agency', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'List of agency to iterate on (if no values all agencies)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $agenciesSlugs = $input->getOption('agency');

        if (!$agenciesSlugs) {
            $agenciesSlugs = $this->em->createQuery('SELECT a.slug FROM ' . Agency::class . ' a')
                ->getArrayResult();
            $agenciesSlugs = array_column($agenciesSlugs, 'slug');
        }
        foreach ($agenciesSlugs as $slug) {

            $agency = $this->contextStorage->activateContextBySlug($slug);

            $output->writeln('');
            $output->writeln("<info> ----- Execute for Agency $agency ----- </info>");

            $this->executeInAgency($agency, $input, $output);
            
            $output->writeln('');
        }
    }


    abstract protected function executeInAgency(Agency $agency, InputInterface $input, OutputInterface $output);

}
