<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Tests;

use Andaniel05\TestUtils\Db;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;
use PDO;

setTestCaseNamespace(__NAMESPACE__);
setTestCaseClass(TestCase::class);

testCase('DbTest.php', function () {
    testCase('mysql', function () {
        setUpBeforeClass(function () {
            $db = new PDO($_ENV['MYSQL_DSN'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASS']);

            $sql = file_get_contents(__DIR__.'/db.sql');
            $db->exec($sql);

            static::setVar('db', $db);
        });

        testCase('#getTables()', function () {
            test(function () {
                $expected = [
                    'country',
                    'user',
                ];

                $this->assertEquals($expected, Db::getTables($this->db));
            });
        });

        testCase('#getAllData()', function () {
            test(function () {
                $expected = [
                    'country' => [
                        ['id' => 2, 'code' => 'cu'],
                        ['id' => 1, 'code' => 'es'],
                    ],
                    'user' => [
                        ['id' => 1, 'username' => 'andy', 'country_id' => 1],
                        ['id' => 2, 'username' => 'daniel', 'country_id' => 2],
                    ],
                ];

                $this->assertEquals($expected, Db::getAllData($this->db));
            });
        });
    });

    testCase('sqlite', function () {
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

                $this->assertEquals($expected, Db::getTables($this->pdo));
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

                $this->assertEquals($expected, Db::getAllData($this->pdo));
            });
        });
    });
});
