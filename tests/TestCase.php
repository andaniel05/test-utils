<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Tests;

use Andaniel05\TestUtils\AssertsTrait;
use ThenLabs\PyramidalTests\Utils\StaticVarsInjectionTrait;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class TestCase extends PHPUnitTestCase
{
    use AssertsTrait;
    use StaticVarsInjectionTrait;

    public function setUp()
    {
        $this->injectVars();
    }
}
