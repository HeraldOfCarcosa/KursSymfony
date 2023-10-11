<?php


namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class CodeGenerator
{
    public Filesystem $filesystem; //czemu to jest czerwone????


    private string $codePrefix;
    /**
     * @param Filesystem $filesystem
     * @param string $codePrefix
     */

     public function __construct(Filesystem $filesystem, string $codePrefix)
     {
        $this->filesystem = $filesystem;
        $this->codePrefix = $codePrefix;
     }
    public function generate(): string
    {

        $code = $this->codePrefix . rand(1000, 9000);


        $this->filesystem->mkdir('codes');
        $this->filesystem->touch('codes/'.$code.'.txt');
        file_put_contents('codes/'.$code.'.txt', $code);
        return $code;
    }
}