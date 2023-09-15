<?php

session_start();
require_once '../Models/User.php';

function login() {
    $response = ['status' => 'error', 'message' => '로그인 실패!'];

    if (isset($_POST['id']) && isset($_POST['password'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $user = new User();

        $result = $user->loginUser($id, $password);
        if ($result) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['user_idx'] = $result['user_idx'];
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

    function logout() {
        // 세션을 파기합니다.
        session_destroy();

        // JSON 응답을 생성합니다.
        $response = ['status' => 'success'];

        // JSON 응답을 반환합니다.
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
        case 'logout':
            echo json_encode(logout());
            break;
        // 추가로 필요한 기능들을 case로 계속 확장 가능
    }
}



