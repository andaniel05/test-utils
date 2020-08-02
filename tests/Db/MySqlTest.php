<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Tests\Db;

use Andaniel05\TestUtils\Db\MySql;
use Andaniel05\TestUtils\Tests\TestCase;
use PDO;

setTestCaseNamespace(__NAMESPACE__);
setTestCaseClass(TestCase::class);

testCase('MySqlTest.php', function () {
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

            $this->assertEquals($expected, MySql::getTables($this->db));
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

            $this->assertEquals($expected, MySql::getAllData($this->db));
        });

        test('#truncateAllTables()', function () {
            MySql::truncateAllTables($this->db);

            $expected = [
                'country' => [],
                'user' => [],
            ];

            $this->assertEquals($expected, MySql::getAllData($this->db));
        });
    });
});
