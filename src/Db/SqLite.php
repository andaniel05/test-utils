<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Db;

use PDO;
use PDOStatement;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 * @final
 */
final class SqLite implements DbInterface
{
    public static function getTables(PDO $pdo): array
    {
        $result = [];

        $sql = "SELECT name FROM sqlite_master WHERE type = 'table'";
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

    public static function truncateAllTables(PDO $db): void
    {
        $tables = self::getTables($db);
        $sql = 'SET FOREIGN_KEY_CHECKS=0;';

        foreach ($tables as $tableName) {
            $sql .= "TRUNCATE TABLE {$tableName};";
        }

        $sql .= 'SET FOREIGN_KEY_CHECKS=1;';

        $db->exec($sql);
    }

    public static function getSchema(PDO $db): array
    {
        // TODO

        return [];
    }
}
