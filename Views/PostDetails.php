<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
echo "글보기 페이지";
?>