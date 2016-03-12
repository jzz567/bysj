<?php

abstract class Model {
    public static $db;

    public function __construct() {
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
        try {
            self::$db = new PDO($dsn, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            die("连接数据库出错");
        }
        return true;
    }
}