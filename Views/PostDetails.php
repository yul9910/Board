<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Models/Board.php'; // Board.php를 참조합니다.

$board = new Board(); // Board 객체를 생성합니다.

if (!isset($_GET['post_idx']) || empty($_GET['post_idx'])) {
    die("게시글 번호가 올바르지 않습니다.");
}

$post_idx = $_GET['post_idx'];
$postDetails = $board->getPostDetails($post_idx); // Board 객체를 사용하여 getPostDetails 메서드를 호출합니다.

if (!$postDetails) {
    die("게시글을 찾을 수 없습니다.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 상세보기</title>
    <link rel="stylesheet" href="../assets/Css/PostDetail.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/Js/Post.js"></script>
    <script src="../assets/Js/Comment.js"></script>
    <script src="../assets/Js/logout.js?vs=2"></script>
</head>
<body>
<nav>
    <a href="DashBoard.php">PHP 게시판 웹 사이트</a>
    <div>
        <a href="DashBoard.php">게시판</a>
        <?php
        if (isset($_SESSION['user_idx'])) {
            echo '<a href="#" id="logoutBtn">로그아웃</a>';
        } else {
            echo '<a href="Login.php">로그인</a>';
            echo '<a href="Register.php">회원가입</a>';
        }
        ?>
    </div>
</nav>
<h2>글보기 페이지</h2>

<div class="post-details">
    <h3 id="title"><?php echo htmlspecialchars($postDetails['title']); ?></h3>
    <pid id="content"><?php echo nl2br(htmlspecialchars($postDetails['content'])); ?></pid>

    <?php
    // 작성자만 수정, 삭제 버튼 보이도록
    if (isset($_SESSION['user_idx']) && $_SESSION['user_idx'] == $postDetails['user_idx']) {
        ?>
        <div class="actions">
            <button id="editBtn" onclick="location.href='CreatePost.php?post_idx=<?php echo $postDetails['post_idx']; ?>'">수정</button>
            <button id="delBtn" data-post-idx="<?php echo $postDetails['post_idx']; ?>">삭제</button>
        </div>
        <?php
    }
    ?>
    <div class="return-to-list">
        <button onclick="redirectToDashboard()" class="actions button">글 목록</button>
    </div>
</div>

<input type="hidden" id="post_idx" value="<?php echo $post_idx; ?>">
<div class="comment-section">
    <h4>댓글</h4>

    <!-- 댓글 입력창 -->
    <?php if (isset($_SESSION['user_idx'])) { ?>
        <div class="comment-input">
            <textarea id="comment-textarea" placeholder="댓글을 입력하세요..."></textarea>
            <button id="comment-submit-btn">확인</button>
        </div>
    <?php } ?>

    <!-- 댓글 리스트 -->
    <div class="comment-list">
        <?php
        $comments = $board->getCommentsByPost($post_idx);

        if (empty($comments)) {
            echo '<p>등록된 댓글이 없습니다.</p>';
        } else {
            foreach ($comments as $comment) {
                echo '<div class="comment-item">';

                echo '<p>'.htmlspecialchars($comment['content']).'</p>';
                echo '<span>'.htmlspecialchars($comment['regdate']).'</span>';

                if (isset($_SESSION['user_idx']) && $_SESSION['user_idx'] == $comment['user_idx']) {
                    echo '<button data-comment-id="'.$comment['comment_idx'].'" class="comment-edit-btn">수정</button>';
                    echo '<button data-comment-id="'.$comment['comment_idx'].'" class="comment-delete-btn">삭제</button>';
                }

                echo '</div>';
            }
        }
        ?>
    </div>
</div>


</body>
</html>
