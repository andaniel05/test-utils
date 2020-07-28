<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Tests;

use PHPUnit\Framework\AssertionFailedError;

setTestCaseNamespace(__NAMESPACE__);
setTestCaseClass(TestCase::class);

testCase('AssertsTraitTest.php', function () {
    testCase('#assertExpectedArrayDiff()', function () {
        testCase('fail', function () {
            setUp(function () {
                $this->expectException(AssertionFailedError::class);
            });

            test(function () {
                $array1 = [];
                $array2 = ['db' => [1, 2, 3]];

                $exceptionMessage = <<<MSG
                Unexpected Array Diff:
                [
                    'db' => [
                        1,
                        2,
                        3
                    ]
                ]
                MSG;

                $this->expectExceptionMessage($exceptionMessage);

                $this->assertExpectedArrayDiff($array1, $array2);
            });
        });

        testCase('pass', function () {
            test(function () {
                $array1 = ['db' => []];
                $array2 = $array1;

                $this->assertExpectedArrayDiff($array1, $array2);
            });

            test(function () {
                $array1 = [];
                $array2 = ['db' => []];

                $expects = ['db' => []];

                $this->assertExpectedArrayDiff($array1, $array2, $expects);
            });

            test(function () {
                $array1 = [];
                $array2 = ['db' => []];

                $expects = ['db' => $this->equalTo([])];

                $this->assertExpectedArrayDiff($array1, $array2, $expects);
            });

            test(function () {
                $array1 = [];
                $array2 = ['db' => []];

                $expects = ['db' => function () {
                    return true;
                }];

                $this->assertExpectedArrayDiff($array1, $array2, $expects);
            });

            test(function () {
                $array1 = [
                    'db' => [
                        'table1' => [
                            ['id' => 0, 'col1' => 'val1', 'col2' => uniqid()],
                        ],
                    ],
                ];

                $array2 = $array1;
                $array2['db']['table1'][0]['col1'] = 'val2';

                $expects = [
                    'db' => [
                        'table1' => [
                            ['col1' => $this->equalTo('val2')],
                        ],
                    ],
                ];

                $this->assertExpectedArrayDiff($array1, $array2, $expects);
            });
        });
    });
});
