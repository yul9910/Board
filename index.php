<?php
require_once("Database.php");

$db = new Database();
$conn = $db->getConnection();

// 여기서 $conn 을 사용해 SQL 쿼리를 수행할 수 있습니다.

echo "Git";

$result = $conn->query("SELECT DATABASE();");
$row = $result->fetch_assoc();
echo $row['DATABASE()'];

?>