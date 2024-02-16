<?php

namespace Config;

class Database {
    // defined as static, which means you can call it without instantiating the Database class. 
    // This is useful for creating a database connection without needing to create an instance of the class.
    public static function connect() {
        $config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'gbgdb'
        ];

        $conn = new \mysqli($config['host'], $config['username'], $config['password'], $config['database']);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}