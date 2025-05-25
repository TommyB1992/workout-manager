<?php
namespace App\Models;

use PDO;

class WorkoutRep extends Model {
    protected const string TABLE = 'workout_rep';

    public static function readByWorkoutId(int $workout_id): array {
        $stmt = self::db()->prepare("SELECT * FROM workout_rep WHERE workout_id = ?");
        $stmt->execute([$workout_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $workout_id, float $weight, int $num, int $rec_min, int $rec_sec): void {
        $stmt = self::db()->prepare("INSERT INTO workout_rep (workout_id, weight, num, rec_min, rec_sec) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$workout_id, $weight, $num, $rec_min, $rec_sec]);
    }

    public static function update(int $workout_rep_id, int $workout_id, float $weight, int $num, int $rec_min, int $rec_sec): void {
        $stmt = self::db()->prepare("UPDATE workout_rep SET weight = ?, num = ?, rec_min = ?, rec_sec = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$weight, $num, $rec_min, $rec_sec, $workout_rep_id]);
    }
}
