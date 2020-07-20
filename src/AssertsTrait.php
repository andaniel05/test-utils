<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils;

use PHPUnit\Framework\AssertionFailedError;
use Brick\VarExporter\VarExporter;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
trait AssertsTrait
{
    public function assertExpectedArrayDiff(array $array1, array $array2, array $expects): void
    {
        $diff = array_udiff($array1, $array2, function ($value1, $value2) {
            return $value1 !== $value2;
        });

        if (empty($diff)) {
            $this->assertTrue(true);
            return;
        } else {
            $message = "\nUnexpected Array Diff:\n".VarExporter::export($diff);
            fwrite(STDERR, $message);
            throw new AssertionFailedError;
        }
    }
}
