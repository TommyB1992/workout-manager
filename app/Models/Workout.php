<?php
namespace App\Models;

use App\Helpers\SqlHelper;
use PDO;

class Workout extends Model {
    protected const string TABLE = 'workout';

    public static function getWorkoutsByDates(array $dates): array {
        $placeholders = SqlHelper::buildPlaceholders($dates);
        $stmt = self::db()->prepare("
            SELECT w.id w_id, w.date, t.name t_name, e.name e_name
            FROM workout w
            LEFT JOIN training_method t ON w.training_id = t.id
            LEFT JOIN exercise e ON w.exercise_id = e.id
            WHERE w.date IN ($placeholders)
            ORDER BY w.id ASC
        ");
        $stmt->execute($dates);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * TODO: Put into a service
     */
    public static function getReportByDates(array $dates): array {
        $placeholders = SqlHelper::buildPlaceholders($dates);
        $stmt = self::db()->prepare("
            SELECT wp.weight, wp.num AS reps, mw.involvement, m.id, m.name
            FROM workout w
            INNER JOIN workout_rep wp ON wp.workout_id = w.id
            INNER JOIN muscle_worked mw ON mw.exercise_id = w.exercise_id
            INNER JOIN muscle m ON m.id = mw.muscle_id AND m.enabled = 1
            WHERE w.date IN ($placeholders)
        ");
        $stmt->execute($dates);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(int $exercise_id, ?int $training_id, string $desc, string $date): void {
        $stmt = self::db()->prepare("INSERT INTO workout (exercise_id, training_id, `desc`, `date`) VALUES (?, ?, ?, ?)");
        $stmt->execute([$exercise_id, $training_id, $desc, $date]);
    }

    public static function update(int $workout_id, int $exercise_id, int $training_id, string $desc): void {
        $stmt = self::db()->prepare("UPDATE workout SET exercise_id = ?, training_id = ?, `desc` = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$exercise_id, $training_id, $desc, $workout_id]);
    }
}