<?php

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testInstantiation()
    {
        $client = new \smtomusicai\Main();
        $this->assertNotNull($client);
    }
}