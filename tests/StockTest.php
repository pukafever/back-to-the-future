<?php

namespace BackToTheFuture\tests;

use BackToTheFuture\data\Stock;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase
{
    public function testGetfromdilpReturnsCode5WhenConnectionFails()
    {
        $this->stock = new Stock();
        $this->expected = array(
            'code' => 5,
            'message' => 'TEST: There was an error while trying to login to the netcomponents API.',
            'body' => 'API error:'
        );

        $this->actual = $this->stock->getFromDilp('TEST');

        $this->assertEquals($this->expected['code'], $this->actual['code']);
        $this->assertEquals($this->expected['message'], $this->actual['message']);
        $this->assertStringContainsString($this->expected['body'], $this->actual['body']);
    }
    public function testGetReturnsCode5WhenTheDbIsOffline()
    {
        $this->stock = new Stock();
        $this->expected = array(
            'code' => 5,
            'message' => 'Could not create a connection to the database.',
            'body' => ''
        );

        $this->assertSame($this->expected, $this->stock->get('', 0));
    }
}
