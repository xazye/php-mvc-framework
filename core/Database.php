<?php

namespace app\core;

use PDO;

class Database
{
    public PDO $pdo;
    public function __construct(array $config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $migrations = scandir(Application::$ROOT_DIR . '/migrations');
        $newMigrations = array_diff($migrations, $appliedMigrations);
        $currentylAppliedMigrations = [];
        foreach ($newMigrations as $migration) {
            if ($migration == '.' || $migration == '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = str_replace('.php', '', $migration);
            $class = new $className();
            $this->log('applying migration '. $migration);
            $class->up();
            $this->log('migration '. $migration . ' applied');
            $currentylAppliedMigrations[] = $migration;
        }
        if (count($currentylAppliedMigrations) > 0) {
            $this->saveMigrations($currentylAppliedMigrations);
        } else {
            $this->log('no new migrations to apply');
        }
    }
    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY ,
            migration VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    }
    public function getAppliedMigrations()
    {
        $sql = "SELECT migration FROM migrations";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $migrations = $statement->fetchAll(PDO::FETCH_COLUMN);
        return $migrations;
    }
    public function saveMigrations(array $migrations)
    {
        $migrations = implode(",",array_map(fn ($migration) => "('$migration')", $migrations));
        $sql = "INSERT INTO migrations(migration) VALUES $migrations";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    }
    protected function log($message){
        echo '['. date('Y-m-d H:i:s') . ']' . $message. "\n";
    }
}
