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
    setUpBeforeClass(function () {
        $originalDbFileName = __DIR__.'/db.sqlite';
        $dbFileName = __DIR__.'/db-'.time().'.sqlite';

        copy($originalDbFileName, $dbFileName);

        static::setVar('dbFileName', $dbFileName);
    });

    tearDownAfterClass(function () {
        $dbFileName = static::getVar('dbFileName');
        unlink($dbFileName);
    });

    testCase('#showTables()', function () {
        test(function () {
            $pdo = new PDO('sqlite:'.$this->dbFileName);

            $expected = [];

            $this->assertEquals($expected, Db::showTables($pdo));
        });
    });
});
