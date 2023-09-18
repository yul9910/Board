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
        $query = "SELECT * FROM `user` WHERE id = '$id' AND password = '$password'";
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
                    VALUES (1, '$id', '$password', '$name', 'N', 'N')";

//        if(!mysqli_query($this->db->DataBase, $query)) {
//            error_log("Error: " . mysqli_error($this->db->DataBase));  // 오류 로깅
//            return false;
//        }

        if(mysqli_query($this->db->DataBase, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getName($post_idx)
    {
        $query = "select name from `user` left outer join `post` on user.user_idx = post.post_idx where post_idx= $post_idx";
        if (mysqli_query($this->db->DataBase, $query)) {
            return true;  // 댓글 삭제 성공
        }
    }

}

$user = new User();
?>
