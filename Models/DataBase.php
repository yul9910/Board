<?php

class DataBase {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'board_db';
    public $DataBase;

    public function __construct()
    {
        $this->connection();
    }

    public function connection()
    {
        $this->DataBase = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $this->DataBase->set_charset("utf8");

        echo (mysqli_connect_errno()) ? "데이터베이스 연결 실패: " . mysqli_connect_error() : "데이터베이스 연결 성공!!";

        return $this->DataBase;
    }
}

$DataBase = new DataBase();

?>
