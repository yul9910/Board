<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 게시판 웹 사이트</title>
    <link rel="stylesheet" href="../assets/Css/styles.css">
    <script src="../assets/Js/Login.js"></script>
</head>
<body>
<nav>
    <a href="main.php">PHP 게시판 웹 사이트</a>
    <div>
        <a href="main.php">메인</a>
        <a href="list.php">게시판</a>
        <a href="Login.php">로그인</a>
        <a href="Register.php">회원가입</a>
    </div>
</nav>
<div class="container">
    <h3 style="text-align: center">로그인 화면</h3>
    <form name="join" method="post" action="../Controllers/UserController.php">
        <div class="form-group">
            <input type="text" placeholder="아이디" name="id" id="id" maxlength="20" required>
        </div>
        <div class="form-group">
            <input type="password" placeholder="비밀번호" name="password" id="password" maxlength="80" required>
        </div>
        <button class="btn" type="submit" onclick="check_input()">로그인</button>
        <button class="btn" type="button" onclick="reset_form()">초기화</button>
    </form>
</div>
