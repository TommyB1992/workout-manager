<?php
namespace App\Models;

use App\Core\Database;
use PDO;

abstract class Model {
    protected const string TABLE = '';

    protected static PDO $pdo;

    public static function init(): void {
        if (!isset(self::$pdo)) {
            self::$pdo = Database::getConnection();
        }
    }

    protected static function db(): PDO {
        self::init();
        return self::$pdo;
    }

    public static function getAll(string $orderBy = 'name'): array {
        $table = static::TABLE;
        $stmt = self::db()->query("SELECT * FROM `$table` ORDER BY `$orderBy` ASC");
        return self::toArrayCol($stmt);
    }

    public static function read(int $id, string $fields = '*'): array|false {
        $table = static::TABLE;
        $stmt = self::db()->prepare("SELECT $fields FROM `$table` WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete(int $id): void {
        $table = static::TABLE;
        $stmt = self::db()->prepare("DELETE FROM `$table` WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
    }

    public static function existsByName(string $name): bool {
        $table = static::TABLE;
        $stmt = self::db()->prepare("SELECT 1 FROM `$table` WHERE name = ? LIMIT 1");
        $stmt->execute([$name]);
        return $stmt->fetchColumn() !== false;
    }

    public static function existsById(int $id): bool {
        $table = static::TABLE;
        $stmt = self::db()->prepare("
            SELECT 1
            FROM `$table`
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() !== false;
    }

    protected static function toArrayCol(\PDOStatement $stmt, string $key = 'id', string $value = 'name'): array {
        $rows = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    
        // Caso 1: solo 2 colonne, tipo id => name
        if (!empty($rows) && count($rows[0]) === 2) {
            return array_column($rows, $value, $key);
        }
    
        // Caso 2: più di 2 colonne, tipo id => [altri campi]
        $result = [];
        foreach ($rows as $row) {
            $id = $row[$key];
            unset($row[$key]);
            $result[$id] = $row;
        }
    
        return $result;
    }
}