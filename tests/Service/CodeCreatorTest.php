<?php
namespace App\Tests\Service;

use App\Service\CodeCreator;
use PHPUnit\Framework\TestCase;

class CodeCreatorTest extends TestCase
{
    public function testCreateCode(): void
    {
        $codeCreator = new CodeCreator();
        $code = $codeCreator->createCode('test');

        $this->assertIsString($code);
        $this->assertEquals(9, strlen($code));
    }
}