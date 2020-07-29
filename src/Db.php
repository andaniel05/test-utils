<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils;

use PDO;
use PDOStatement;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 * @abstract
 */
abstract class Db
{
    public static function getTables(PDO $pdo): array
    {
        $result = [];

        $query = $pdo->query("SELECT name FROM sqlite_master WHERE type = 'table'");

        if ($query instanceof PDOStatement) {
            foreach ($query as $row) {
                $result[] = $row['name'];
            }
        }

        return $result;
    }
}
