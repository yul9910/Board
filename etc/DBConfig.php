<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'board_db';



$connect = mysqli_connect($host, $username, $password);

    if (!$connect) {
        die("서버와의 연결 실패! : ".mysqli_connect_error());


    }

    echo "서버와의 연결 성공!";

?>