<?php

namespace Database;

use PDO;
use PDOException;

class Connection {
    private const HOST = 'localhost';
    private const PORT = '3306';
    private const DBNAME = 'JACAL_COURSE';
    private const USERNAME = 'root';
    private const PASSWORD = 's2next-root';

    private const CONFIG = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true
    ];

    private const DSN = 'mysql:host='. self::HOST .';port='. self::PORT .';dbname='. self::DBNAME .';charset=utf8mb4';

    static private $cnn = null;

    static public function initCnn(){
        try {
            self::$cnn = new PDO( self::DSN, self::USERNAME, self::PASSWORD, self::CONFIG );
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
    }

    static public function getCnn() {
        return self::$cnn;
    }

    static public function query( $query, $params = [] ) {
        $response = [];

        try {
            $stmt = self::$cnn->prepare( $query );
            $stmt->execute( $params );

            $response = [
                'error' => '',
                'count' => $stmt->rowCount(),
                'response' => $stmt->fetchAll(),
            ];
        } catch (PDOException $e) {
            $response = [
                'error' => $e->getMessage(),
                'count' => 0,
                'response' => [],
            ];
        }
        Connection::closeCnn();
        return $response;
    }

    static public function closeCnn() {
        self::$cnn = null;
    }
}