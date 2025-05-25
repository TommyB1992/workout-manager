<?php
namespace App\Models;

use PDO;

class TrainingMethod extends Model {
    protected const string TABLE = 'training_method';

    public static function create(string $name, string $desc, string $js_file): void {
        $stmt = self::db()->prepare("INSERT INTO training_method (name, description, js_file) VALUES (?, ?, ?)");
        $stmt->execute([$name, $desc, $js_file]);
    }

    public static function update(int $train_id, string $name, string $desc, string $js_file): void {
        $stmt = self::db()->prepare("UPDATE training_method SET name = ?, description = ?, js_file = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$name, $desc, $js_file, $train_id]);
    }
}
