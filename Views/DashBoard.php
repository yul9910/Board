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
    <title>대시보드</title>
</head>
<body>
<h1>환영합니다, <?php echo $_SESSION['user_id']; ?>님!</h1>
</body>
</html>
