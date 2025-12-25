<?php

class DatabaseService
{
    private static $instance;
    private $connection;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseService();
        }
        return self::$instance;
    }

    function __construct()
    {
        $this->connection = new mysqli('localhost', 'root', '', 'larkon');
        
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    function checkUser($email)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    function __destruct()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

?>