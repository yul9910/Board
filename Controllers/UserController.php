<?php
session_start();
require_once '../Models/User.php';

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

echo json_encode($response);
?>
