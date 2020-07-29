<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\Constraint\Constraint;
use Brick\VarExporter\VarExporter;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
trait AssertsTrait
{
    public function assertExpectedArrayDiff(array $array1, array $array2, array $expects = []): void
    {
        $diff = TestUtils::arrayRecursiveDiff($array2, $array1);

        $callback = function (array $inputArray, array &$diff) use (&$callback) {
            foreach ($inputArray as $key => $value) {
                if (! array_key_exists($key, $diff)) {
                    throw new ExpectationFailedException("The difference has not the data '{$key}'.");
                }

                if (is_array($value)) {
                    $callback($value, $diff[$key]);

                    if (empty($diff[$key])) {
                        unset($diff[$key]);
                    }
                } else {
                    $unset = false;

                    if (is_callable($value)) {
                        $contraintCallback = $value;
                        if (true == call_user_func($contraintCallback, $diff[$key])) {
                            $unset = true;
                        }
                    } elseif ($value instanceof Constraint) {
                        $contraint = $value;
                        $unset = $contraint->evaluate($diff[$key]);
                    } elseif ($diff[$key] === $value) {
                        $unset = true;
                    }

                    if ($unset == true) {
                        unset($diff[$key]);
                    }
                }
            }
        };

        $callback($expects, $diff);

        if (empty($diff)) {
            $this->assertTrue(true);
            return;
        }

        throw new AssertionFailedError(
            "\nUnexpected Array Diff:\n".VarExporter::export($diff)
        );
    }
}
