<?php
class DataBase {
private $host = 'localhost';
private $username = 'root';
private $password = '';
private $database = 'board';
public $DataBase;

public function __construct()
{
$this->connection();
}

    public function connection()
    {
        $this->DataBase = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $this->DataBase->set_charset("utf8");

        if(mysqli_connect_errno()) {
            throw new Exception("데이터베이스 연결 실패: " . mysqli_connect_error());
        }

        $db_name = $this->DataBase->query("SELECT DATABASE()")->fetch_row()[0];
       // echo "데이터베이스 연결 성공!! Connected to database: " . $db_name;

        return $this->DataBase;
    }


}

$db = new DataBase();
