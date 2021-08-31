<?php

require_once 'vendor/autoload.php';

use Sants\SoapDebugger\Command\GetSoapWsdlCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new GetSoapWsdlCommand());
$application->run();
