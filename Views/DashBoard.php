<?php
session_start();
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
        echo '<h1>환영합니다, ' . $_SESSION['user_id'] . '님!</h1>';
    }
    ?>
</div>

</body>
</html>
