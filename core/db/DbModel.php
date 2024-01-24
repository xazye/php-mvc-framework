<?php

namespace app\core\db;

use app\core\Model;
use app\core\Application;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract static public function primaryKey(): string;
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
    public function findOne($where)
    {

        $table = static::tableName();
        $columns = array_keys($where);
        $whereSlqPart = implode(' AND ', array_map(fn ($attr) => "$attr = :$attr", $columns));
        $sql = "SELECT * FROM $table WHERE $whereSlqPart";
        $statement = self::prepare($sql);
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement->fetchObject(static::class);
        // if($result){
        //     foreach($result as $key => $value){
        //         $this->$key = $value;
        //     }
        //     return true;
        // }
        // return false;

    }
}
