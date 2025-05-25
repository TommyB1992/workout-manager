<?php
namespace App\Models;

use PDO;

class Muscle extends Model {
    protected const string TABLE = 'muscle';

    public static function create(string $name, bool|int $enabled): void {
        $stmt = self::db()->prepare("INSERT INTO muscle (name, enabled) VALUES (?, ?)");
        $stmt->execute([$name, $enabled]);
    }

    public static function update(int $muscle_id, string $name, bool|int $enabled): void {
        $stmt = self::db()->prepare("UPDATE muscle SET name = ?, enabled = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$name, $enabled, $muscle_id]);
    }

    public static function getAllEnabled(): array {
        $stmt = self::db()->query("SELECT id, name FROM muscle WHERE enabled = 1");
        return self::toArrayCol($stmt);
    }
}
