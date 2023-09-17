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
    <link rel="stylesheet" href="../assets/Css/PostDetail.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/Js/Post.js"></script>
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
    // 로그인한 사용자만 수정, 삭제 버튼 보이도록
    if (isset($_SESSION['user_idx'])) {
        ?>
    <!-- 기존의 버튼 코드를 아래와 같이 수정합니다. -->
    <div class="actions">
        <button id="editBtn" onclick="location.href='CreatePost.php?post_idx=<?php echo $postDetails['post_idx']; ?>'">수정</button>
        <button id="delBtn" data-post-idx="<?php echo $postDetails['post_idx']; ?>">삭제</button>
    </div>

    <?php } ?>
    <div class="return-to-list">
        <button onclick="redirectToDashboard()" class="btn">글 목록</button>
    </div>

</div>
</body>
</html>
