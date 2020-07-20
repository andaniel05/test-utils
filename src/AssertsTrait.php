<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils;

use PHPUnit\Framework\AssertionFailedError;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
trait AssertsTrait
{
    public function assertExpectedArrayDiff(array $array1, array $array2, array $expects): void
    {
        $this->assertEquals($array1, $array2);
    }
}
