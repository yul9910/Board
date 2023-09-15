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
    <a href="main.php">PHP 게시판 웹 사이트</a>
    <div>
        <a href="main.php">메인</a>
        <a href="list.php">게시판</a>
        <a href="login.php">로그인</a>
        <a href="Register.php">회원가입</a>
    </div>
</nav>

<div class="container">
    <h3 style="text-align: center">글 작성 화면</h3>
    <form name="createPost" method="post">
        <div class="form-group">
            <input type="text" placeholder="제목" name="title" id="title" maxlength="50" required>
        </div>
        <div class="form-group">
            <textarea placeholder="내용" name="content" id="content" cols="110" rows="20" required></textarea>
        </div>
        <div class="form-group">
            <label for="is_secret">비밀글: </label>
            <input type="hidden" name="is_secret" value="N">
            <input type="checkbox" name="is_secret" id="is_secret" value="Y">
        </div>
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