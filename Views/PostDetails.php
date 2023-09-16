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
</head>
<body>
<h2>글보기 페이지</h2>

<div class="post-details">
    <h3><?php echo htmlspecialchars($postDetails['title']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($postDetails['content'])); ?></p>

    <?php
    // 로그인한 사용자만 수정, 삭제 버튼 보이도록
    if (isset($_SESSION['user_idx'])) {
        ?>
        <div class="actions">
            <button onclick="editPost(<?php echo $postDetails['post_idx']; ?>)">수정</button>
            <button onclick="deletePost(<?php echo $postDetails['post_idx']; ?>)">삭제</button>
        </div>
    <?php } ?>
</div>

<script>
    function editPost(post_idx) {
        // AJAX를 사용하여 게시글 수정 로직 구현
    }

    function deletePost(post_idx) {
        // AJAX를 사용하여 게시글 삭제 로직 구현
    }
</script>
</body>
</html>
