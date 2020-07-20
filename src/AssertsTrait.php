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
    public function assertExpectedArrayDiff(array $array1, array $array2, array $expects = []): void
    {
        $diff = array_udiff($array2, $array1, function ($value1, $value2) {
            return $value1 !== $value2;
        });

        foreach ($expects as $key => $value) {
            if ($diff[$key] === $value) {
                unset($diff[$key]);
            }
        }

        if (empty($diff)) {
            $this->assertTrue(true);
            return;
        }

        throw new AssertionFailedError(
            "\nUnexpected Array Diff:\n".VarExporter::export($diff)
        );
    }
}
