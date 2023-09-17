<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Models/Board.php';
$board = new Board();

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // 현재 페이지
$perPage = 10;  // 페이지당 게시글 수

$totalPosts = $board->getTotalPostCount();  // 전체 게시글 수
$totalPages = ceil($totalPosts / $perPage);  // 전체 페이지 수

$posts = $board->getPosts($currentPage, $perPage);
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

<div class="container">
    <?php
    if (isset($_SESSION['user_idx'])) {
        ?>
        <div class="welcome-box">
            <h1>환영합니다, <?php echo $_SESSION['user_id']; ?>님!</h1>
        </div>

    <?php
    } else {
    // 세션에 'shownLoginAlert' 변수가 설정되지 않았다면 알림을 표시하고 세션 변수를 설정합니다.
    if (!isset($_SESSION['shownLoginAlert'])) {
    $_SESSION['shownLoginAlert'] = true;
    ?>
        <script>
            window.onload = function() {
                notifyLogin();
            }

            function notifyLogin() {
                alert("로그인 후 게시판을 이용할 수 있습니다.");
            }
        </script>
        <?php
    }
    }
    ?>


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
                    <td><a href="PostDetails.php?post_idx=<?php echo $post['post_idx']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></td>
                    <td><?php echo $post['regdate']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- 글 쓰기 버튼 추가 -->
    <div class="write-post-button">
        <?php if (isset($_SESSION['user_idx'])): ?>
            <button onclick="location.href='CreatePost.php'">글 쓰기</button>
        <?php endif; ?>
    </div>


    <!-- 페이지네이션 링크 출력 -->
    <?php
    if ($totalPages > 1) {
        echo '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo "<span>$i</span>";
            } else {
                echo "<a href='DashBoard.php?page=$i'>$i</a>";
            }
        }
        echo '</div>';
    }
    ?>
</div>
</body>
</html>