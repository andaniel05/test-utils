<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils;

use PDO;
use PDOStatement;
use Brick\VarExporter\VarExporter;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 * @abstract
 */
abstract class Db
{
    public static function getTables(PDO $pdo): array
    {
        $result = [];
        $sql = 'SHOW TABLES';

        $driverName = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driverName == 'sqlite') {
            $sql = "SELECT name FROM sqlite_master WHERE type = 'table'";
        }

        $query = $pdo->query($sql);

        if ($query instanceof PDOStatement) {
            foreach ($query as $row) {
                $result[] = $row['name'];
            }
        }

        return $result;
    }

    public static function getAllData(PDO $db): array
    {
        $result = [];

        $tables = self::getTables($db);
        foreach ($tables as $tableName) {
            $sql = "SELECT * FROM {$tableName}";
            $query = $db->query($sql);
            $result[$tableName] = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }
}
