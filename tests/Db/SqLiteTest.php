<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Tests;

use Andaniel05\TestUtils\Db\SqLite;
use PDO;

setTestCaseNamespace(__NAMESPACE__);
setTestCaseClass(TestCase::class);

testCase('SqLiteTest.php', function () {
    setUpBeforeClass(function () {
        $originalDbFileName = __DIR__.'/db.sqlite';
        $dbFileName = __DIR__.'/db-'.time().'.sqlite';

        copy($originalDbFileName, $dbFileName);

        static::setVar('dbFileName', $dbFileName);
    });

    setUp(function () {
        $this->pdo = new PDO('sqlite:'.$this->dbFileName);
    });

    tearDownAfterClass(function () {
        $dbFileName = static::getVar('dbFileName');
        unlink($dbFileName);
    });

    testCase('#getTables()', function () {
        test(function () {
            $expected = [
                'sqlite_sequence',
                'animals',
                'persons',
            ];

            $this->assertEquals($expected, SqLite::getTables($this->pdo));
        });
    });

    testCase('#getAllData()', function () {
        test(function () {
            $expected = [
                'sqlite_sequence' => [
                    ['name' => 'persons', 'seq' => 2],
                    ['name' => 'animals', 'seq' => 2],
                ],
                'animals' => [
                    ['id' => 1, 'name' => 'dog'],
                    ['id' => 2, 'name' => 'cat'],
                ],
                'persons' => [
                    ['id' => 1, 'name' => 'Andy Navarro', 'age' => 31],
                    ['id' => 2, 'name' => 'Daniel Tano',  'age' => 32],
                ],
            ];

            $this->assertEquals($expected, SqLite::getAllData($this->pdo));
        });
    });
});
