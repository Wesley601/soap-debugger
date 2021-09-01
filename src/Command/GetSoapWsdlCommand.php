<?php

namespace Sants\SoapDebugger\Command;

use Sants\SoapDebugger\Services\SoapTest;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetSoapWsdlCommand extends Command
{
    protected static $defaultName = 'soap:debug';

    protected function configure(): void
    {
        $this
            ->setDescription('Get info from wsdl api')
            ->setHelp('This command help to search for wsdl info')
            ->addArgument('urlWsdl', InputArgument::REQUIRED, 'url for the wsdl')
            ->addOption('functions', 'f', InputOption::VALUE_NONE, 'get functions from the wsdl')
            ->addOption('types', 't', InputOption::VALUE_NONE, 'get types from the wsdl')
            ->addOption('functionFilter', 'ff', InputOption::VALUE_OPTIONAL, 'filter functions from the wsdl', null)
            ->addOption('typeFilter', 'tf', InputOption::VALUE_OPTIONAL, 'filter types from the wsdl', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $soapTest = new SoapTest($input->getArgument('urlWsdl'));

        $err = $soapTest->init();
        if ($err != null) {
            $output->writeln([
                $err
            ]);
            return Command::FAILURE;
        }

        if ($input->getOption('functions')) {
            $filter = $input->getOption('functionFilter');
            $filterFunc = $filter
                ? fn ($var) => str_contains($var, $filter)
                : null;

            $output->writeln($soapTest->getFunctions($filterFunc));
        }

        if ($input->getOption('types')) {
            $filter = $input->getOption('typeFilter');
            $filterFunc = $filter
                ? fn ($var) => str_contains($var, $filter)
                : null;

            $output->writeln($soapTest->getTypes($filterFunc));
        }

        return Command::SUCCESS;
    }
}
