<?php

class User {

private $db;

public function __construct($database) {
$this->db = $database;
}

public function createUser($group_idx, $id, $password, $name) {
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $this->db->prepare("INSERT INTO User (group_idx, id, password, name, is_delete, is_disp) VALUES (?, ?, ?, ?, 'N', 'N')");
return $stmt->execute([$group_idx, $id, $hashedPassword, $name]);
}

public function getUserById($user_idx) {
$stmt = $this->db->prepare("SELECT * FROM User WHERE user_idx = ? AND is_delete = 'N'");
$stmt->execute([$user_idx]);
return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateUser($user_idx, $data) {
$sql = "UPDATE User SET ";
$params = [];

foreach ($data as $key => $value) {
$sql .= "$key = ?,";
$params[] = $value;
}

$sql = rtrim($sql, ',');
$sql .= " WHERE user_idx = ?";
$params[] = $user_idx;

$stmt = $this->db->prepare($sql);
return $stmt->execute($params);
}

public function deleteUser($user_idx) {
$stmt = $this->db->prepare("UPDATE User SET is_delete = 'Y' WHERE user_idx = ?");
return $stmt->execute([$user_idx]);
}
}
?>
