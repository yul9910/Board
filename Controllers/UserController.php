<?php

session_start();
require_once '../Models/User.php';

function login() {
    $response = ['status' => 'error', 'message' => '로그인 실패!'];

    if (isset($_POST['id']) && isset($_POST['password'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $user = new User();

        if ($user->loginUser($id, $password)) {
            $_SESSION['user_id'] = $id;
            $response = ['status' => 'success', 'redirect' => '../Views/DashBoard.php'];
        }
    }
    return $response;
}

function register() {
    $response = ['status' => 'error', 'message' => '회원가입 실패!'];

    if (isset($_POST['id']) && isset($_POST['password'])  && isset($_POST['name'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $name = $_POST['name'];

        $user = new User();

        if ($user->registerUser($id, $password, $name)) {
            $response = ['status' => 'success', 'message' => '회원가입 성공!','redirect' => '../Views/DashBoard.php'];
        }
    }

    return $response;
}

// 실행하려는 함수에 따라서 호출
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            echo json_encode(login());
            break;
        case 'register':
            echo json_encode(register());
            break;
        // 추가로 필요한 기능들을 case로 계속 확장 가능합니다.
    }
}



