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


function deletepost(){

}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'post':
            echo json_encode(post());
            break;
        case 'edit':
            echo json_encode(editpost());
            break;
        // 추가로 필요한 기능들을 case로 계속 확장
    }
}
