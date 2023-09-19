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
            $_SESSION['group_idx'] = $result['group_idx'];

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

    function unregister() {
        $response = ['status' => 'error', 'message' => '회원 탈퇴 실패!'];

        // 세션에서 사용자 아이디를 확인
        if (isset($_SESSION['user_idx'])) {
            $user_idx = $_SESSION['user_idx'];

            $user = new User();

            // unregisterUser 메서드를 호출하여 사용자를 삭제
            if ($user->unregisterUser($user_idx)) {
                // 성공 시 세션 종료
                session_destroy();
                $response = ['status' => 'success', 'message' => '회원 탈퇴 성공!', 'redirect' => '../Views/Login.php'];
            }
        }

        return $response;
    }

// 실행하려는 함수에 따라서 호출
// json_encode = php값을 json 형식의 문자열로 반환해줌
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            echo json_encode(login()); // 응답 전송
            break;
        case 'register':
            echo json_encode(register());
            break;
        case 'logout':
            echo json_encode(logout());
            break;
        case 'unregister':
            echo json_encode(unregister());
            break;
        // 추가로 필요한 기능들을 case로 계속 확장 가능
    }
}



