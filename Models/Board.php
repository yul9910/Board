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

        // 사용자의 user_idx가 유효한지 확인 (ㅇ)
        if ($userResult && mysqli_num_rows($userResult) == 1) {
            // 게시물 생성 쿼리 실행
            $query = "INSERT INTO `Post` (user_idx, group_idx, title, content, is_secret) 
                        VALUES ($user_idx, 1, '$title', '$content', '$is_secret')";
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

    public function updateBoard($post_idx, $title, $content, $is_secret,$group_idx) {
    // 게시물의 소유자인지 확인하기 위해 게시물의 user_idx 값을 가져옴.
    $getOwnerQuery = "SELECT user_idx FROM `Post` WHERE post_idx = $post_idx";
    $ownerResult = mysqli_query($this->db->DataBase, $getOwnerQuery);
    $ownerData = mysqli_fetch_assoc($ownerResult);

    // 세션의 user_idx 값과 게시물의 user_idx 값을 비교하여 해당 게시물을 수정할 권한이 있는지 확인함.
    // 또는 $_SESSION['group_idx']가 2인 경우에도 수정할 수 있도록 조건을 추가함.
    if ($ownerData && ($ownerData['user_idx'] == $_SESSION['user_idx'] || $_SESSION['group_idx'] == 2)) {
        // 게시물 수정 쿼리 실행
        $query = "UPDATE `Post` 
                    SET title = '$title', content = '$content', is_secret = '$is_secret' 
                    WHERE post_idx = $post_idx";

        if (mysqli_query($this->db->DataBase, $query)) {
            // 게시물이 성공적으로 삭제되었다면 성공 값을 반환함.
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

    public function deleteBoard($post_idx, $group_idx) {
        // 게시물의 소유자인지 확인하기 위해 게시물의 user_idx 값을 가져옴!
        $getOwnerQuery = "SELECT user_idx FROM `post` 
                            WHERE post_idx = $post_idx";
        $ownerResult = mysqli_query($this->db->DataBase, $getOwnerQuery);
        $ownerData = mysqli_fetch_assoc($ownerResult);

        // 세션의 user_idx 값과 게시물의 user_idx 값을 비교하여 해당 게시물을 삭제할 권한이 있는지 확인함.
        if ($ownerData && ($ownerData['user_idx'] == $_SESSION['user_idx'] || $_SESSION['group_idx'] == 2)) {
            // 게시물 삭제 쿼리 실행
            $query = "DELETE FROM `post` WHERE post_idx = $post_idx";

            if (mysqli_query($this->db->DataBase, $query)) {
                // 게시물이 성공적으로 삭제되었다면 성공 값을 반환함.
                return [
                    'success' => true
                ];
            }
        }

        // 게시물 삭제 실패 시
        return [
            'success' => false,
        ];
    }


    public function getTotalPostCount() {
        $query = "SELECT COUNT(post_idx) as total FROM post 
                    WHERE is_delete='N' AND is_disp='Y'";
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
        // is_secret과 user_idx 값을 쿼리에 포함
        $query = "SELECT post_idx, title, content, is_secret, user_idx, regdate FROM post 
                   WHERE is_delete='N' AND is_disp='Y' 
                   ORDER BY regdate 
                   DESC LIMIT $offset, $perPage";
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

    public function createComment($content, $user_idx, $post_idx, $group_idx) {
        $sql = "INSERT INTO `comment` (content, user_idx, post_idx, group_idx, is_delete, is_disp, regdate, moddate) 
                VALUES ('$content', $user_idx, $post_idx, $group_idx, 'N', 'Y', NOW(), NOW())";

        if ($this->db->DataBase->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    //$post_idx를 가지고 해당 게시글에 연결된 모든 댓글을 가져오는 함수!
    public function getCommentsByPost($post_idx) {
        $post_idx = (int)$post_idx;

        // 데이터베이스의 정확한 테이블 이름과 컬럼 이름을 확인하세요.
        $query = "SELECT content, regdate, user_idx, comment_idx FROM `comment` 
                    WHERE post_idx = $post_idx AND is_delete='N' AND is_disp='Y' 
                    ORDER BY regdate DESC";

        // 데이터베이스 연결 객체를 사용하는 부분입니다.
        // 이 부분은 $this->db와 연관된 클래스의 정의에 따라 달라질 수 있습니다.
        $result = $this->db->DataBase->query($query);

        $comments = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
            $result->free();
        }

        return $comments;
    }

    public function updateComment($commentId, $newContent, $user_idx) {
        $query = "UPDATE `comment` SET content = '$newContent' 
                 WHERE comment_idx = $commentId AND user_idx = $user_idx";
        $result = mysqli_query($this->db->DataBase, $query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteComment($comment_idx, $user_idx){
    $comment_idx = (int) $comment_idx; // 정수로 변환

    // 댓글이 해당 사용자에게 속하는지 확인하는 쿼리
    $getOwnerQuery = "SELECT user_idx FROM `comment`
                        WHERE comment_idx = $comment_idx";
    $ownerResult = mysqli_query($this->db->DataBase, $getOwnerQuery);
    $ownerData = mysqli_fetch_assoc($ownerResult);

    // 사용자 확인
    if ($ownerData && ($ownerData['user_idx'] == $_SESSION['user_idx'] || $_SESSION['group_idx'] == 2)) {
        $query = "DELETE FROM `comment`  
                        WHERE comment_idx = $comment_idx";

        if (mysqli_query($this->db->DataBase, $query)) {
            return true;  // 댓글 삭제 성공
        }
    }
    return false; // 댓글 삭제 실패
}

}

$board = new Board();

?>
