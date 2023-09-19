<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Models/Board.php';

$board = new Board();

if (!isset($_GET['post_idx']) || empty($_GET['post_idx'])) {
    die("게시글 번호가 올바르지 않습니다.");
}

$post_idx = $_GET['post_idx'];
$postDetails = $board->getPostDetails($post_idx);

if (!$postDetails) {
    die("게시글을 찾을 수 없습니다.");
}
$isUserLoggedIn = isset($_SESSION['user_idx']);
$isUserAuthor = $_SESSION['user_idx'] == $postDetails['user_idx'];
$isUserInGroup2 = isset($_SESSION['group_idx']) && $_SESSION['group_idx'] == 2;
$isUserAllowed = $isUserLoggedIn && ($isUserAuthor || $isUserInGroup2);

$comments = $board->getCommentsByPost($post_idx);

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
            echo '<a href="#" id="unregBtn">탈퇴</a>'; // 탈퇴 버튼 추가
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
    <!--nl2br 은 새로운 줄을 표시하는 기호를 HTML에서 인식할 수 있도록 br 태그로 변환해줌-->
    <pid id="content"><?php echo nl2br(htmlspecialchars($postDetails['content'])); ?></pid>

    <?php
    if ($isUserAllowed) {
        ?>
        <div class="actions">
            <button id="editBtn"
                    onclick="location.href='CreatePost.php?post_idx=<?php echo $postDetails['post_idx']; ?>'">수정</button>
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

    <?php if (isset($_SESSION['user_idx'])) { ?>
        <div class="comment-input">
            <textarea id="comment-textarea" placeholder="댓글을 입력하세요..."></textarea>
            <button id="comment-submit-btn">확인</button>
        </div>
    <?php } ?>

    <div class="comment-list">
        <?php

        if (empty($comments)) {
            echo '<p>등록된 댓글이 없습니다.</p>';
        } else {
            foreach ($comments as $comment) {
                echo '<div class="comment-item">';
                echo '<strong>' . htmlspecialchars($comment['username']) . '</strong>'.'&nbsp;'.' / ';  // 작성자 이름 출력
                echo '&nbsp;'.'<p>'.htmlspecialchars($comment['content']).'</p>';
                echo '<span>'.htmlspecialchars($comment['regdate']).'</span>';

                if (isset($_SESSION['user_idx']) && ($_SESSION['user_idx'] == $comment['user_idx']
                        || (isset($_SESSION['group_idx']) && $_SESSION['group_idx'] == 2)))
                {
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
