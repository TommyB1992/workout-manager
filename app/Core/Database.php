<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../../config/database.php';

            $host = $config['DB_HOST'];
            $dbname = $config['DB_NAME'];
            $user = $config['DB_USER'];
            $pass = $config['DB_PASS'];
            $charset = $config['DB_CHARSET'];

            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

            try {
                self::$connection = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
