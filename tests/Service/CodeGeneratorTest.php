<?php

namespace App\Tests\Service;

use App\Service\CodeCreator;
use App\Service\CodeGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class CodeGeneratorTest extends KernelTestCase
{

    public function testGenerateCode()
    {

        self::bootKernel();
        $container = static::getContainer();

        $fileSystem = $container->get(Filesystem::class);
        $codeCreator = $container->get(CodeCreator::class);


        $codeGenerator = new CodeGenerator(
            $fileSystem,
            $codeCreator,
            'ABC'

        );

        $code = $codeGenerator->generate();
        $this->assertIsString($code);
        $this->assertMatchesRegularExpression('/[A-Z]{}-[0-9]{4}/', $code);

    }
}
