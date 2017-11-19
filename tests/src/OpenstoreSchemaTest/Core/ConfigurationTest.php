<?php

namespace OpenstoreSchemaTest\Core;

use OpenstoreSchema\Core\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    protected function setUp()
    {
    }

    public function testGetEntityNamespace()
    {
        self::assertInternalType('string', Configuration::getEntityNamespace());
    }
}
