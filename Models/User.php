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
        $query = "SELECT * FROM `user` WHERE id = '$id' AND password = '$password' AND is_delete='N'";
        $result = mysqli_query($this->db->DataBase, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return [
                'success' => true,
                'user_idx' => $row['user_idx'],  //idx 값을 반환합니다.
                'id' => $row['id'],
                'group_idx' => $row['group_idx']  // group_idx 값을 추가로 반환합니다.
            ];
        } else {
            return [
                'success' => false
            ];
        }
    }


    public function registerUser($id, $password, $name)
    {
        $query = "INSERT INTO `user` (group_idx, id, password, name, is_delete, is_disp) 
                    VALUES (1, '$id', '$password', '$name', 'N', 'Y')";

        if(mysqli_query($this->db->DataBase, $query)) {
            return true;
        } else {
            return false;
        }
    }

      //논리적 삭제로 변경!
      public function unregisterUser($user_idx) {
        // 사용자 아이디를 기반으로 삭제 쿼리를 작성
          $query = "UPDATE `user` SET is_delete='Y' WHERE user_idx = $user_idx";


          // 쿼리 실행
        if (mysqli_query($this->db->DataBase, $query)) {
            return true;  // 사용자 삭제(논리적 삭제) 성공
        }

        return false; // 사용자 삭제 실패
    }

}

$user = new User();
?>
