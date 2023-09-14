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

// 연결 상태 메시지 출력 제거
// echo (mysqli_connect_errno()) ? "데이터베이스 연결 실패: " . mysqli_connect_error() : "데이터베이스 연결 성공!!";

if(mysqli_connect_errno()) {
throw new Exception("데이터베이스 연결 실패: " . mysqli_connect_error());
}

return $this->DataBase;
}
}

