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
    <script src="../assets/Js/unregister.js"></script>
    <script>
        $(document).on('click', '.secret-post', function(e) {
            e.preventDefault();
            alert("비밀글입니다.");
        });
    </script>
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
    <?php
    if (isset($_SESSION['user_idx'])) {
        echo '<div class="welcome-box">';
        echo '<h1>환영합니다, ' . $_SESSION['user_id'] . '님!</h1>';
        echo '</div>';
    } else {
        if (!isset($_SESSION['shownLoginAlert'])) {
            $_SESSION['shownLoginAlert'] = true;
            echo '<script>
                window.onload = function() {
                    notifyLogin();
                }

                function notifyLogin() {
                    alert("로그인 후 게시판을 이용할 수 있습니다.");
                }
            </script>';
        }
    }
    ?>

    <div class="posts-box">
        <table class="posts-list">
            <thead>
            <tr>
                <th>게시글 번호</th>
                <th>제목</th>
                <th>등록일</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($posts as $post):
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['post_idx']); ?></td>
                    <td>
                        <?php
                        if ($post['is_secret'] == 'Y' && (!isset($_SESSION['user_idx']) || $_SESSION['user_idx'] === null || ($_SESSION['user_idx'] !== $post['user_idx'] && $_SESSION['group_idx'] != 2)))
                        {
                            // 비밀글 표시
                            echo '<a href="#" class="secret-post" data-post-author="'.$post['user_idx'].'">'.htmlspecialchars($post['title']).' (🔒)</a>';
                        } else {
                            // 비밀글이 아님 or 로그인한 사용자가 게시글 작성자 or 그룹 인덱스가 2인 경우
                            echo '<a href="PostDetails.php?post_idx='.$post['post_idx'].'">'.htmlspecialchars($post['title']).'</a>';
                        }
                        ?>
                    </td>
                    <td><?php echo $post['regdate']; ?></td>
                </tr>
            <?php
            endforeach;
            ?>
            </tbody>
        </table>
    </div>

    <div class="write-post-button">
        <?php
        if (isset($_SESSION['user_idx']) || (isset($_SESSION['group_idx']) && $_SESSION['group_idx'] == 2)) {
            echo '<button onclick="location.href=\'CreatePost.php\'">글 쓰기</button>';
        }
        ?>
    </div>

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
