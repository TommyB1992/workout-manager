<?php
/**
 * Muscle Manager
 * 
 * @author: Tomas Bartoli
 */

namespace App\Models;

use App\Core\Database;
use PDO;

class Exercise extends Model {
    protected const string TABLE = 'exercise';

    public static function create(string $name): void {
        $stmt = self::db()->prepare("INSERT INTO exercise (name) VALUES (?)");
        $stmt->execute([$name]);
    }

    public static function update(int $exercise_id, string $name): void {
        $stmt = self::db()->prepare("UPDATE exercise SET name = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$name, $exercise_id]);
    }
}
