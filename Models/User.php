<?php

require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new DataBase(); // DataBase 객체를 생성합니다.
    }

    public function getDb() {
        return $this->db;
    }

    public function loginUser($id, $password) {
    $query = "SELECT * FROM user WHERE id = '$id' AND password = '$password'";
    $result = mysqli_query($this->db->DataBase, $query);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

    public function registerUser($id, $password, $name)
    {
        $query = "INSERT INTO User (group_idx, id, password, name, is_delete, is_disp) VALUES (1, '$id', '$password', '$name', 'N', 'N')";

        if(mysqli_query($this->db->DataBase, $query)) {
            return true;
        } else {
            return false;
        }
    }

}

$user = new User();
?>
