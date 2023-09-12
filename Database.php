<?php
// Database.php

require_once("DBConfig.php");

class Database extends DBConfig {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);

        if($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Get the database connection
    public function getConnection() {
        return $this->connection;
    }

    // Close the database connection
    public function closeConnection() {
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }
}
?>
