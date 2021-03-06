<?php

namespace OpenSpout\Writer\Exception\Border;

use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Writer\Exception\WriterException;

class InvalidNameException extends WriterException
{
    public function __construct($name)
    {
        $msg = '%s is not a valid name identifier for a border. Valid identifiers are: %s.';

        parent::__construct(sprintf($msg, $name, implode(',', BorderPart::getAllowedNames())));
    }
}
