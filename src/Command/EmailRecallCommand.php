<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Contract;
use Faker\Provider\cs_CZ\DateTime;

class EmailRecallCommand extends AbstractAgencyCommand
{
    protected static $defaultName = 'app:email-recall';

    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Envoi de mail de rappel au client')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function executeInAgency(\App\Entity\Agency $agency,InputInterface $input, OutputInterface $output)
    {

        $contractExpiring = $this->em->getRepository(Contract::class)
                            ->createQueryBuilder('c')
                            ->where('c.date < :date_max')
                            ->setParameter('date_max', new \DateTime('-4 years'))
                            ->getQuery()
                            ->getResult()
                            ;

        $output->writeln(count($contractExpiring).' contracts expiring, sending recall email');

        foreach($contractExpiring as $c){

            $output->writeln(' - Contract '.$c->getClient().' signed at '.$c->getDate()->format('Y-m-d'));

        }

    }
}
