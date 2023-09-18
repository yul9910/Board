<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Models/Board.php';
$board = new Board();

// 현재 페이지 번호를 URL의 쿼리 파라미터(page)에서 가져오는 코드
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // 현재 페이지

$perPage = 10;  // 페이지당 게시글 수

$totalPosts = $board->getTotalPostCount();  // 전체 게시글 수
$totalPages = ceil($totalPosts / $perPage);  // 전체 페이지 수
/*
전체 게시글 수 ($totalPosts)를 페이지당 게시글 수 ($perPage)로 나누어 전체 페이지 수를 계산합니다.
ceil 함수는 결과값을 올림하여 정수로 만듭니다.
예를 들어, 총 25개의 게시글이 있고 페이지당 10개의 게시글을 표시하려면 3페이지가 필요하므로 ceil 함수는 2.5를 3으로 올림합니다.
*/

$posts = $board->getPosts($currentPage, $perPage);
/*
 board 객체의 getPosts 메서드를 호출하여 현재 페이지의 게시글 가져옴 getPosts 메서드는 해당 페이지의 게시글 목록을 반환합니다.
  */
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
        // 알림표시를 한번만 하기위해
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
                <!--htmlspecialchars : 문자열에서 특정한 특수 문자를 HTML 엔티티로 변환하는 함수!-->
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
        for ($i = 1; $i <= $totalPages; $i++) { // 각 페이지 번호를 출력하기 위한 반복문
            if ($i == $currentPage) { //현재 반복 중인 페이지 번호($i)가 현재 페이지 번호가 동일
                echo "<span>$i</span>"; // 텍스트로만 출력 , 링크X
            } else {
                echo "<a href='DashBoard.php?page=$i'>$i</a>"; // 아니라면 해당 페이지 번호로 이동할 수 있는 링크 생성
            }
        }
        echo '</div>';
    }
    ?>
</div>
</body>
</html>
