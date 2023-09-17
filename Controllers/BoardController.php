<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Models/Board.php';

if (!isset($_SESSION['user_id'])) {
    // 사용자가 로그인되어 있지 않으면 로그인 페이지로 리다이렉트
    header('Location: login.php');
    exit;
}

// 실행하려는 함수에 따라서 호출
function post(){
    $response = ['status' => 'error', 'message' => '작성 실패!'];

    // 세션에서 user_idx 값을 가져옴?
    if (isset($_SESSION['user_idx']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['is_secret'])) {
        $user_idx = $_SESSION['user_idx'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $is_secret = $_POST['is_secret'];
        $board = new Board();

        // 함수 호출에 user_idx 포함
        if ($board->createBoard($title, $content, $is_secret, $user_idx)) {
            $response = ['status' => 'success', 'message' => '글작성 성공!', 'redirect' => '../Views/DashBoard.php'];
        }
    }
    return $response;
}

function editpost(){
    $response = ['status' => 'error', 'message' => '수정 실패!'];

    if (isset($_SESSION['user_idx']) && isset($_POST['post_idx']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['is_secret'])) {

        $user_idx = $_SESSION['user_idx'];
        $post_idx = $_POST['post_idx'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $is_secret = $_POST['is_secret'];

        $board = new Board();

        // updateBoard() 메서드는 게시글의 ID를 첫 번째 인자로 받아서 해당 게시글을 수정하는 로직을 포함해야 합니다.
        if ($board->updateBoard($post_idx, $title, $content, $is_secret, $user_idx)) {
            $response = ['status' => 'success', 'message' => '글수정 성공!', 'redirect' => '../Views/DashBoard.php'];
        }
    }
    return $response;
}


function deletepost() {
    $response = ['status' => 'error', 'message' => '삭제 실패!'];

    if (isset($_SESSION['user_idx']) && isset($_POST['post_idx'])) {

        $user_idx = $_SESSION['user_idx'];
        $post_idx = $_POST['post_idx'];

        $board = new Board();

        // deleteBoard() 메서드는 게시글의 ID를 첫 번째 인자로 받아서 해당 게시글을 삭제하는 로직을 포함해야 합니다.
        if ($board->deleteBoard($post_idx, $user_idx)) { // 일반적으로 게시글을 삭제할 때 작성자의 ID도 같이 검사해서 해당 사용자가 그 게시글을 삭제할 권한이 있는지 확인합니다.
            $response = ['status' => 'success', 'message' => '글삭제 성공!', 'redirect' => '../Views/DashBoard.php'];
        }
    }

    return $response;
}

function comment() {
    $response = ['status' => 'error', 'message' => '댓글 작성 실패!'];

    if (isset($_SESSION['user_idx']) && isset($_POST['content']) && isset($_POST['post_idx']) && isset($_POST['group_idx'])) {
        $user_idx = $_SESSION['user_idx'];
        $content = $_POST['content'];
        $post_idx = $_POST['post_idx'];
        $group_idx = $_POST['group_idx'];

        $board = new Board();

        if ($board->createComment($content, $user_idx, $post_idx, $group_idx)) {
            $response = ['status' => 'success', 'message' => '댓글 작성 성공!'];
        }
    }
    return $response;
}


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'post':
            echo json_encode(post());
            break;
        case 'edit':
            echo json_encode(editpost());
            break;
        case 'delete':
            echo json_encode(deletepost());
            break;
        case 'comment':
            echo json_encode(comment());
            break;
        // 추가로 필요한 기능들을 case로 계속 확장
    }
}
