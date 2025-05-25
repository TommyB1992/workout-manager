<?php
namespace App\Models;

use PDO;

class MuscleWorked extends Model {
    protected const string TABLE = 'muscle_worked';

    public static function getAll(string $orderBy = 'exercise_name'): array {
        $stmt = self::db()->query("
            SELECT mw.id, mw.involvement, m.name muscle_name, e.name exercise_name
            FROM muscle_worked mw
            LEFT JOIN exercise e ON e.id=mw.exercise_id
            LEFT JOIN muscle m ON m.id=mw.muscle_id
            ORDER BY `$orderBy` ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $exercise_id, int $muscle_id, string $involvement): void {
        $stmt = self::db()->prepare("INSERT INTO muscle_worked (exercise_id, `muscle_id`, involvement) VALUES (?, ?, ?)");
        $stmt->execute([$exercise_id, $muscle_id, $involvement]);
    }

    public static function exists(int $exercise_id, int $muscle_id): bool {
        $stmt = self::db()->prepare("
            SELECT 1
            FROM muscle_worked
            WHERE exercise_id = ? AND muscle_id = ?
            LIMIT 1
        ");
        $stmt->execute([$exercise_id, $muscle_id]);
        return $stmt->fetchColumn() !== false;
    }
}
