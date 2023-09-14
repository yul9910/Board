<?php

require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new DataBase(); // DataBase 객체를 생성합니다.
    }

    public function SelectMethod() {
        $result = mysqli_query($this->db->DataBase, "SELECT * FROM user");
        while ($row = mysqli_fetch_assoc($result)) {
            var_dump($row);  // <-- 이 부분을 추가
            echo "<hr>";    // 각 행의 구분을 위해 추가
            echo "이름 : " . $row['name'];
            echo "<br>";
            echo "아이디 : " . $row['id'];
            echo "<hr>";
        }
    }

}

$user = new User();
$user->selectMethod();

?>
