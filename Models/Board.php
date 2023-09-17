<?php
 // 세션 시작
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'DataBase.php';

Class Board {
    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }

    public function getDb() {
        return $this->db;
    }

    public function createBoard($title, $content, $is_secret,$user_idx) {

        // user_idx를 가져오는 쿼리 실행
        if(!empty($user_idx)){
            $getUserIdxQuery = "SELECT user_idx FROM `user` WHERE user_idx = $user_idx"; // 혹은 다른 조건에 따라 사용자를 식별하는 쿼리로 변경할 수 있음
            $userResult = mysqli_query($this->db->DataBase, $getUserIdxQuery);
        }

        // 사용자의 user_idx가 유효한지 확인
        if ($userResult && mysqli_num_rows($userResult) == 1) {
            // 게시물 생성 쿼리 실행
            $query = "INSERT INTO `Post` (user_idx, group_idx, title, content, is_secret) VALUES ($user_idx, 1, '$title', '$content', '$is_secret')";

            if (mysqli_query($this->db->DataBase, $query)) {
                // 게시물이 성공적으로 생성되었다면, 해당 게시물의 user_idx 값을 반환
                return [
                    'success' => true,
                    'user_idx' => $user_idx,
                ];
            }
        }

        // 사용자가 존재하지 않거나 게시물 생성 실패 시
        return [
            'success' => false,
        ];
    }

    public function updateBoard($post_idx, $title, $content, $is_secret) {
        // 게시물의 소유자인지 확인하기 위해 게시물의 user_idx 값을 가져옵니다.
        $getOwnerQuery = "SELECT user_idx FROM `Post` WHERE post_idx = $post_idx";
        $ownerResult = mysqli_query($this->db->DataBase, $getOwnerQuery);
        $ownerData = mysqli_fetch_assoc($ownerResult);

        // 세션의 user_idx 값과 게시물의 user_idx 값을 비교하여 해당 게시물을 수정할 권한이 있는지 확인합니다.
        if ($ownerData && $ownerData['user_idx'] == $_SESSION['user_idx']) {
            // 게시물 수정 쿼리 실행
            $query = "UPDATE `Post` SET title = '$title', content = '$content', is_secret = '$is_secret' WHERE post_idx = $post_idx";

            if (mysqli_query($this->db->DataBase, $query)) {
                // 게시물이 성공적으로 수정되었다면 성공 값을 반환합니다.
                return [
                    'success' => true
                ];
            }
        }

        // 게시물 수정 실패 시
        return [
            'success' => false,
        ];
    }

    public function deleteBoard(){}

    public function getTotalPostCount() {
        $query = "SELECT COUNT(post_idx) as total FROM post WHERE is_delete='N' AND is_disp='Y'";
        $result = $this->db->DataBase->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        return 0;
    }

    public function getPosts($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;

        $posts = [];
        $query = "SELECT post_idx, title, content, regdate FROM post WHERE is_delete='N' AND is_disp='Y' ORDER BY regdate DESC LIMIT $offset, $perPage";
        $result = $this->db->DataBase->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            $result->free();
        }

        return $posts;
    }

    public function getPostDetails($post_idx) {
        $post_idx = (int) $post_idx; // 안전한 쿼리를 위해 정수로 변환합니다.
        $query = "SELECT * FROM post WHERE post_idx = $post_idx LIMIT 1";
        $result = $this->db->DataBase->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $result->free();
            return $row;
        } else {
            return false;
        }
    }

}

$board = new Board();
?>
