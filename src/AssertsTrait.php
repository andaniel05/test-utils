<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
trait AssertsTrait
{
    public function assertExpectedArrayDiff(array $array1, array $array2, array $expects = []): void
    {
        Asserts::assertExpectedArrayDiff($array1, $array2, $expects);
    }
}
