<?php

class db_connection
{
    private $host = 'localhost';       // 데이터베이스 서버 주소
    private $username = 'root';        // 데이터베이스 사용자 이름
    private $password = '';    // 데이터베이스 비밀번호
    private $database = 'board_db'; // 사용할 데이터베이스 이름
    protected $conn;

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    public function __construct()
    {
        $this->connectDB();
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn)
    {
        $this->conn = $conn;
    }



    private function connectDB()
    {
        $connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        $this->setConn($connect);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }


}

$db = new db_connection();  // 데이터베이스 연결 인스턴스 생성
$conn = $db->getConn();    // $conn 변수를 통해 데이터베이스 연결 객체 사용
?>




