<?php


namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class CodeGenerator
{
     public function __construct(
         public Filesystem $filesystem,
         public CodeCreator $creator,
         public string $codePrefix
     )
     {
     }
    public function generate(): string
    {

        $code = $this->creator->createCode($this->codePrefix);


        $this->filesystem->mkdir('codes');
        $this->filesystem->touch('codes/'.$code.'.txt');
        file_put_contents('codes/'.$code.'.txt', $code);
        return $code;
    }
}