<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use PDO;
use PDOStatement;

class DBModel extends Model
{
    /**
     * Get connection of DB
     * @author Miguel Angel Jimenez
     */
    public function connection(): PDO
    {
        $params = [
            'dbname' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
        ];
        try {
            $connection = new PDO(
                'mysql:host=' . $params['host'] . ';dbname=' . $params['dbname'],
                $params['user'],
                $params['password']
            );
        } catch (Exception  $e) {
            $message = 'Error: ' . $e->getMessage();
            die($message);
        }
        return $connection;
    }

    /**
     * @return status and data|message
     */
    public function exec_query($query): array
    {
        $response = $this->connection()->query($query);
        if (!$response) {
            $time = date("Y-m-d H:i:s");
            $error = $this->connection()->errorInfo();
            /* $registro = $time . " - Error: " . $error[0] . " - " . $error[2] . ". En la sentencia: " . $query . " - " . $_SERVER['PHP_SELF'];
            return [
                'status' => false,
                'message' => $registro
            ]; */
            die('Error: Internal server error.');
        }
        $data = [];
        while ($row = $this->fetchAssoc($response)) {
            $data[] = $row;
        }
        return [
            'status' => true,
            'data' => $data
        ];
    }

    public function fetchAssoc($query)
    {
        $response = $query ? $query->fetch(PDO::FETCH_ASSOC) : 0;
        return $response;
    }
}
