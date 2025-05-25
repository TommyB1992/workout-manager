<?php
/**
 * Muscle Manager
 * 
 * @author: Tomas Bartoli
 */

namespace App\Models;

use PDO;

class Measure extends Model {
    protected const string TABLE = 'measure';

    public static function getAllByGroup(): array {
        $stmt = self::db()->query("
             SELECT m.*, g.id g_id, g.name g_name
               FROM measure m 
          LEFT JOIN measure_group g
                 ON g.id=m.group");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $name, ?string $group_id): void {
        $stmt = self::db()->prepare("INSERT INTO measure (name, `group`) VALUES (?, ?)");
        $stmt->execute([$name, $group_id]);
    }

    public static function update(int $measure_id, string $name, ?string $group_id): void {
        $stmt = self::db()->prepare("UPDATE measure SET name = ?, `group` = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$name, $group_id, $measure_id]);
    }
}
