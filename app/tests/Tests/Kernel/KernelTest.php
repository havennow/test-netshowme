<?php

declare(strict_types=1);

namespace Tests\Kernel;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class KernelTest extends KernelTestCase
{
    public function testKernel()
    {
        self::bootKernel();

        $this->assertEquals('App\Kernel', $this->getKernelClass());
    }
}
