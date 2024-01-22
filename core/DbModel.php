<?php

namespace app\core;

use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    public function save()
    {
        $table = $this->tableName();
        $columns = $this->attributes();
        $values = ":" . implode(', :', array_map(fn ($el) => $el, $columns));
        $sql = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES ($values)";
        $statement = self::prepare($sql);
        foreach ($columns as $column) {
            $statement->bindValue(":$column", $this->{$column});
        }
        $statement->execute();
        return true;
    }
    public static function prepare($sql)
    {
        return  Application::$APP->db->pdo->prepare($sql);
    }
}
