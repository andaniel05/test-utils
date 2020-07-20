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

                $this->assertExpectedArrayDiff($array1, $array2);
            });
        });

        createMacro('tests', function () {
            test('fail', function () {
                $this->expectException(AssertionFailedError::class);
                $this->expectExceptionMessage($this->exceptionMessage);

                $this->assertExpectedArrayDiff($this->array1, $this->array2);
            });

            test('pass', function () {
                $this->assertExpectedArrayDiff($this->array1, $this->array2, $this->expects);
            });
        });

        testCase(function () {
            setUp(function () {
                $this->array1 = [];
                $this->array2 = ['db' => []];

                $this->expects = $this->array2;

                $this->exceptionMessage = <<<MSG
                Unexpected Array Diff:
                [
                    'db' => []
                ]
                MSG;
            });

            useMacro('tests');
        });

        // testCase(function () {
        //     setUp(function () {
        //         $this->array1 = ['db' => []];
        //         $this->array2 = ['db' => [1, 2, 3]];

        //         $this->expects = $this->array2;

        //         $this->exceptionMessage = <<<MSG
        //         Unexpected Array Diff:
        //         [
        //             'db' => []
        //         ]
        //         MSG;
        //     });

        //     useMacro('tests');
        // });
    });
});
