<?php
include_once '../Models/User.php';

class UserController {

private $userModel;

public function __construct($db) {
$this->userModel = new User($db);
}

public function register($group_idx, $id, $password, $name) {
return $this->userModel->createUser($group_idx, $id, $password, $name);
}

public function getUser($user_idx) {
return $this->userModel->getUserById($user_idx);
}

public function updateUser($user_idx, $data) {
return $this->userModel->updateUser($user_idx, $data);
}

public function deleteUser($user_idx) {
return $this->userModel->deleteUser($user_idx);
}
}
?>
