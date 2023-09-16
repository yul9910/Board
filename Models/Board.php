<?php
 // 세션 시작
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// 로그인 확인. 이 부분은 사용자가 로그인 상태인지 확인하는거라는데...흐음.......
if (!isset($_SESSION['user_idx'])) { // 변경된 부분
    die("로그인이 필요합니다.");
}

require_once 'Database.php';

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

}

$board = new Board();
?>
