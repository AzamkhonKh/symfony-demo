<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DemoTest extends TestCase
{
    public LoggerInterface $logger;

    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
    public function testAddition()
    {
        $this->assertEquals(4, 2 + 2);
        $this->logger->info('Addition test passed');
    }

    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
    }
}
