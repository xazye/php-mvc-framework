<?php

use app\core\Application;

class m0001_initial
{
    public function up()
    {
        $db = Application::$APP->db;
        $SQL = "Create table users 
        (id int AUTO_INCREMENT PRIMARY KEY, 
        username varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        password varchar(255) NOT NULL,
        status tinyint not null DEFAULT '0',
        created_at timestamp default current_timestamp) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $db->pdo->exec($SQL);
    }
    public function down()
    {
        $db = Application::$APP->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);
    }
}
