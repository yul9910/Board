<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/Js/Login.js"></script>
    <title>대시보드</title>
</head>
<body>
<h1>환영합니다, <?php echo $_SESSION['user_id']; ?>님!</h1>
<button class="btn" type="button" onclick="Logout()">로그아웃</button>
</body>
</html>
