<?php
namespace App\Infrastructure\Persistence;

use PDO;
use App\Config\Config;

class Database {
    private PDO $pdo;

    public function __construct() {
        $config = Config::getInstance();
        $dsn = "pgsql:host={$config->get('DB_HOST')};port={$config->get('DB_PORT')};dbname={$config->get('DB_NAME')}";
        $this->pdo = new PDO($dsn, $config->get('DB_USER'), $config->get('DB_PASSWORD'));
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $encryptionKey = pg_escape_string($this->pdo, $config->get('ENCRYPTION_KEY'));
        $this->pdo->exec("SET app.encryption_key = '$encryptionKey'");
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}