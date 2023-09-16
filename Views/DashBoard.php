<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Models/DataBase.php';
$posts = $db->getPosts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 게시판 웹 사이트</title>
    <link rel="stylesheet" href="../assets/Css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/Js/logout.js?vs=2"></script>
</head>
<body>
<nav>
    <a href="main.php">PHP 게시판 웹 사이트</a>
    <div>
        <a href="main.php">메인</a>
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

<div class="container">
    <?php
    if (!isset($_SESSION['user_idx'])) {
        echo '흠';
    } else {
        ?>
        <div class="welcome-box">
            <h1>환영합니다, <?php echo $_SESSION['user_id']; ?>님!</h1>
        </div>

        <div class="posts-box">
            <!-- 게시글 목록 출력 -->
            <table class="posts-list">
                <thead>
                <tr>
                    <th>게시글 번호</th>
                    <th>제목</th>
                    <th>등록일</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['post_idx']); ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo $post['regdate']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html>
