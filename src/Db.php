<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils;

use PDO;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 * @abstract
 */
abstract class Db
{
    public static function showTables(PDO $pdo): array
    {
        $query = $pdo->query('SHOW TABLES');

        return $query->fetchAll();
    }
}
