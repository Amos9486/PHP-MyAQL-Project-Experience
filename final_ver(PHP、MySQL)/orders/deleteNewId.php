<?php
// require_once './checkSession.php';
session_start();
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";
header("Refresh: 1; url = ./new.php");


//刪除數量
if (!isset($_GET['idx'])) {
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

if (isset($_SESSION['cart'][$_GET['idx']])) {
    //刪除指定索引的位置
    unset($_SESSION['cart'][$_GET["idx"]]);

    header("Refresh: 0; url = ./new.php");
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
//session_unset();