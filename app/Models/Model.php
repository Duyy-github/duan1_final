<?php

namespace App\Models;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class Model
{
    protected $connection;
    protected $table;

    public function __construct()
    {
        $connectionParams = [
            'user'      => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'dbname'    => $_ENV['DB_NAME'],
            'host'      => $_ENV['DB_HOST'],
            'driver'    => $_ENV['DB_DRIVER'],
            'port'      => $_ENV['DB_PORT'],
        ];

        try {
            $this->connection = DriverManager::getConnection($connectionParams);
        } catch (Exception $e) {
            die('Lỗi kết nối CSDL: ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->connection = null;
    }
    public function insert($data)
    {
        try {
            $this->connection->insert($this->table, $data);
            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            return false;
        }
    }
}