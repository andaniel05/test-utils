<?php
declare(strict_types=1);

namespace Andaniel05\TestUtils\Db;

use PDO;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
interface DbInterface
{
    public static function getTables(PDO $pdo): array;

    public static function getAllData(PDO $db): array;

    public static function truncateAllTables(PDO $db): void;
}
