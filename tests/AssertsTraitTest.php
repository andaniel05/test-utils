<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Tests;

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
