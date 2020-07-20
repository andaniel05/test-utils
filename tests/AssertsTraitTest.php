<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Tests;

use PHPUnit\Framework\AssertionFailedError;

setTestCaseNamespace(__NAMESPACE__);
setTestCaseClass(TestCase::class);

testCase('AssertsTraitTest.php', function () {
    testCase('#assertExpectedArrayDiff()', function () {
        testCase('pass', function () {
            test(function () {
                $array1 = ['db' => []];
                $array2 = $array1;

                $this->assertExpectedArrayDiff($array1, $array2, []);
            });
        });

        testCase('fail', function () {
            setUp(function () {
                $this->expectException(AssertionFailedError::class);
            });

            test(function () {
                $array1 = ['db' => []];
                $array2 = [];

                $this->assertExpectedArrayDiff($array1, $array2, []);
            });
        });
    });
});
