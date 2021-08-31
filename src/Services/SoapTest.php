<?php

namespace Sants\SoapDebugger\Services;

use SoapClient;
use SoapFault;

class SoapTest
{
    private SoapClient $soapClient;

    public function __construct(
        private string $urlWsdl
    ) {
    }

    public function init(): ?string
    {
        try {
            $this->soapClient = new SoapClient($this->urlWsdl, [
                'exceptions' => true,
                'trace' => 1,
            ]);

            return null;
        } catch (SoapFault $e) {
            return $e->getMessage();
        }
    }

    public function getFunctions(?callable $func)
    {
        return array_filter($this->soapClient->__getFunctions(), $func);
    }

    public function getTypes(?callable $func)
    {

        return array_filter($this->soapClient->__getTypes(), $func);
    }
}
