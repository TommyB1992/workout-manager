<?php
namespace App\Models;

use PDO;

class MeasureValue extends Model {
    protected const string TABLE = 'measure_value';

    public static function read(int $m_value_id, string $fields = ''): array|false {
        $stmt = self::db()->prepare("
            SELECT mv.*, m.name AS measure_name
            FROM measure_value mv
            INNER JOIN measure m ON mv.measure_id = m.id
            WHERE mv.id = ?
            LIMIT 1
        ");
        $stmt->execute([$m_value_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(int $measure_id, float|string $value, string $date): void {
        $stmt = self::db()->prepare("INSERT INTO measure_value (measure_id, value, `date`) VALUES (?, ?, ?)");
        $stmt->execute([$measure_id, $value, $date]);
    }

    public static function update(int $m_value_id, float|string $value): void {
        $stmt = self::db()->prepare("UPDATE measure_value SET value = ? WHERE id = ? LIMIT 1");
        $stmt->execute([$value, $m_value_id]);
    }

    public static function filter(array $filters): array {
        $groupBy = match($filters['by'] ?? 'day') {
            'week'  => 'week',
            'month' => 'month',
            'year'  => 'year',
            default => 'day',
        };

        [$conditions, $params] = self::buildConditions($filters);
        $query = self::getQuery($groupBy, $conditions);

        $stmt = self::db()->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function buildConditions(array $filters): array {
        $conditions = [];
        $params = [];

        // Filtra per misura (una o più)
        if (!empty($filters['show_by_measure'])) {            
            $measures = array_map('intval', (array) $filters['show_by_measure']);
            if (count($measures) === 1) {
                $conditions[] = 'm.id = :measure_id';
                $params[':measure_id'] = $measures[0];
            } else {
                $placeholders = [];
                foreach ($measures as $index => $id) {
                    $ph = ":measure_id_$index";
                    $placeholders[] = $ph;
                    $params[$ph] = $id;
                }
                $conditions[] = 'm.id IN (' . implode(',', $placeholders) . ')';
            }
            
        }

        // Filtri per data
        if (!empty($filters['show_by_date'])) {
            $conditions[] = 'mv.date = :date_exact';
            $params[':date_exact'] = $filters['show_by_date'];
        } elseif (!empty($filters['start_date']) && empty($filters['end_date'])) {
            $conditions[] = 'mv.date >= :start_date';
            $params[':start_date'] = $filters['start_date'];
        } elseif (empty($filters['start_date']) && !empty($filters['end_date'])) {
            $conditions[] = 'mv.date <= :end_date';
            $params[':end_date'] = $filters['end_date'];
        } elseif (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $conditions[] = 'mv.date BETWEEN :start_date AND :end_date';
            $params[':start_date'] = $filters['start_date'];
            $params[':end_date'] = $filters['end_date'];
        }

        $conditionStr = $conditions ? ' AND ' . implode(' AND ', $conditions) : '';
        return [$conditionStr, $params];
    }

    private static function getQuery(string $groupBy, string $conditions): string {
        return match($groupBy) {
            'week' => "
                SELECT mv.measure_id,
                       YEAR(mv.date) AS year,
                       WEEK(mv.date, 1) AS date,
                       AVG(mv.value) AS value,
                       m.name,
                       m.id AS m_id
                FROM measure_value mv
                INNER JOIN measure m ON mv.measure_id = m.id
                WHERE 1=1 $conditions
                GROUP BY mv.measure_id, m.name, year, date
                ORDER BY year, date
            ",
            'month' => "
                SELECT mv.measure_id,
                       YEAR(mv.date) AS year,
                       MONTH(mv.date) AS date,
                       AVG(mv.value) AS value,
                       m.name,
                       m.id AS m_id
                FROM measure_value mv
                INNER JOIN measure m ON mv.measure_id = m.id
                WHERE 1=1 $conditions
                GROUP BY mv.measure_id, m.name, year, date
                ORDER BY year, date
            ",
            'year' => "
                SELECT mv.measure_id,
                       YEAR(mv.date) AS date,
                       AVG(mv.value) AS value,
                       m.name,
                       m.id AS m_id
                FROM measure_value mv
                INNER JOIN measure m ON mv.measure_id = m.id
                WHERE 1=1 $conditions
                GROUP BY mv.measure_id, m.name, date
                ORDER BY date
            ",
            default => "
                SELECT mv.*,
                       m.name,
                       m.id AS m_id
                FROM measure_value mv
                INNER JOIN measure m ON mv.measure_id = m.id
                WHERE 1=1 $conditions
                ORDER BY mv.date DESC
            "
        };
    }
}
