<?php
// require_once './checkSession.php';
session_start();
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

$strId = join(",", $_POST['chk']);
// print_r($strId);
$check = "SET foreign_key_checks = 0 ";
$stmtDelete1 = $pdo->query($check);




//刪除數量
$count = 0;
$sql = "DELETE FROM `orders` WHERE  FIND_IN_SET(`oId`, ? ) ";
$stmtDelete = $pdo->prepare($sql);
$stmtDelete->execute([$strId]);


$sqlOrderFinal = "DELETE FROM `orders_list` WHERE `oId`  NOT IN (SELECT `oId` FROM `orders`) ";
$stmtUpdate = $pdo->query($sqlOrderFinal);
if ($stmtUpdate->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "已刪除訂單，返回列表";
    header("Refresh: 1; url = ./orders.php");
    // exit();
}
// print_r([$strId]);
// print_r($stmtDelete);

$count = $stmtDelete->rowCount();

// echo $count;

if ($count > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
}
$check1 = "SET foreign_key_checks = 1 ";
$stmtDelete1 = $pdo->query($check1);

header("Refresh: 1; url = ./orders.php");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
