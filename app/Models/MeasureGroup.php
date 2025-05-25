<?php
/**
 * Muscle Manager
 * 
 * @author: Tomas Bartoli
 */

namespace App\Models;

use PDO;

class MeasureGroup extends Model {
    protected const string TABLE = 'measure_group';

    public static function create(string $name): void {
        $stmt = self::db()->prepare("INSERT INTO measure_group (name) VALUES (?)");
        $stmt->execute([$name]);
    }

    public static function update(int $m_group_id, string $name): void {
        $stmt = self::db()->prepare("UPDATE measure_group SET name = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$name, $m_group_id]);
    }
}
