<?php
require_once '../Models/Board.php';
$board = new Board();
if (isset($_GET['post_idx']) && !empty($_GET['post_idx'])) {
    $post_idx = $_GET['post_idx'];
    $postDetails = $board->getPostDetails($post_idx);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 게시판 웹 사이트 - 글 작성</title>
    <link rel="stylesheet" href="/Board/assets/Css/styles.css?after">
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
            echo '<a href="#" id="unregBtn">탈퇴</a>'; // 탈퇴 버튼 추가
        } else {
            echo '<a href="Login.php">로그인</a>';
            echo '<a href="Register.php">회원가입</a>';
        }
        ?>

    </div>
</nav>


<div class="container">
    <h3 style="text-align: center">글 작성 화면</h3>
    <form name="createPost" method="post">
        <div class="form-group">
            <input type="text" placeholder="제목" name="title" id="title" maxlength="50" value="<?php echo isset($postDetails['title']) ? $postDetails['title'] : ''; ?>" required>
        </div>
        <div class="form-group">
            <textarea placeholder="내용" name="content" id="content" cols="110" rows="20" required><?php echo isset($postDetails['content']) ? $postDetails['content'] : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="is_secret">비밀글: </label>
            <input type="hidden" name="is_secret" value="N">
            <input type="checkbox" name="is_secret" id="is_secret" value="Y" <?php echo (isset($postDetails['is_secret']) && $postDetails['is_secret'] === 'Y') ? 'checked' : ''; ?>>
        </div>
        <!-- Hidden input for post_idx -->
        <input type="hidden" name="post_idx" id="post_idx" value="<?php echo isset($post_idx) ? $post_idx : ''; ?>">
        <button class="btn" type="button" id="submitPostBtn">글 작성</button>
        <button class="btn" type="button" onclick="reset_form()">초기화</button>
    </form>
</div>




<script>
    function reset_form() {
        document.createPost.reset();
    }
</script>

</body>
</html>
