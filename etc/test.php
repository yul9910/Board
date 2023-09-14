<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 게시판 웹 사이트</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f1f1f1;
            padding: 0.5em 2em;
        }

        nav a {
            text-decoration: none;
            margin: 0 1em;
            color: #333;
        }

        nav a:hover {
            color: #007BFF;
        }

        .container {
            max-width: 800px;
            margin: 2em auto;
            padding: 1em;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 1em;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 0.5em;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.5em;
            text-align: center;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border: none;
            margin-top: 1em;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .gender-group {
            display: flex;
            justify-content: space-between;
        }

        .gender-group label {
            flex: 1;
            text-align: center;
            padding: 0.5em;
            border: 1px solid #007BFF;
            cursor: pointer;
        }

        .gender-group input[type="radio"] {
            display: none;
        }

        .gender-group label:hover {
            background-color: #007BFF;
            color: white;
        }
    </style>
    <script>
        // 여기에 JS
    </script>
</head>
<body>
<nav>
    <a href="main.php">PHP 게시판 웹 사이트</a>
    <div>
        <a href="main.php">메인</a>
        <a href="list.php">게시판</a>
        <a href="login.php">로그인</a>
        <a href="join.php">회원가입</a>
    </div>
</nav>

<div class="container">
    <h3 style="text-align: center">회원가입 화면</h3>
    <form name="join" method="post" action="join_ok.php">
        <div class="form-group">
            <input type="text" placeholder="아이디" name="id" id="id" maxlength="15">
        </div>
        <div class="form-group">
            <input type="password" placeholder="비밀번호" name="pass" id="pass" maxlength="20">
        </div>
        <div class="form-group">
            <input type="password" placeholder="비밀번호 확인" name="pass_confirm" id="pass_confirm" maxlength="20">
        </div>
        <div class="form-group">
            <input type="text" placeholder="이름" name="name" id="name" maxlength="20">
        </div>
        <div class="form-group gender-group">
            <label>
                <input type="radio" name="gender" value="남자" checked> 남자
            </label>
            <label>
                <input type="radio" name="gender" value="여자"> 여자
            </label>
        </div>
        <div class="form-group">
            <input type="tel" placeholder="전화번호" name="phone" id="phone" maxlength="20">
        </div>
        <div class="form-group">
            <input type="email" placeholder="이메일" name="email" id="email" maxlength="80">
        </div>
        <button class="btn" type="button" onclick="check_input()">회원가입</button>
        <button class="btn" type="button" onclick="reset_form()">초기화</button>
    </form>
</div>
</body>
</html>
