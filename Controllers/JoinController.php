<?php

// 데이터베이스 연결 파일 포함
include 'db_connection.php';

// 입력받은 데이터 받아오기
$id = $_POST['id'];
$password = $_POST['password'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$email = $_POST['email'];

// 비밀번호 암호화
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 데이터베이스에 삽입
$query = "INSERT INTO User (id, password, name) VALUES ('test', 'test', 'test')";

// 쿼리 준비
$stmt = $conn->prepare($query);

// 파라미터 바인드
$stmt->bind_param("ssssss", $id, $hashed_password, $name, $gender, $phone, $email);

// 쿼리 실행
$result = $stmt->execute();

// 결과에 따라 메시지 출력
if ($result) {
    echo "<script>alert('회원 가입이 완료되었습니다.'); location.href='login.php';</script>";
} else {
    echo "<script>alert('오류가 발생했습니다. 다시 시도해주세요.'); history.back();</script>";
}

// 사용한 리소스 해제
$stmt->close();
$conn->close();
