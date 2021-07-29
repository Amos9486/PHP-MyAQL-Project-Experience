<?php
// 引用loading畫面
require_once('./loading.html');

session_start();

unset($_SESSION['username']);

//3 秒後跳頁
header("Refresh: 3; url=./index.php");

//預設訊息
$loginResult['success'] = true;
$loginResult['info'] = "您已登出…3秒後自動回登入頁";
// echo json_encode($loginResult, JSON_UNESCAPED_UNICODE);
