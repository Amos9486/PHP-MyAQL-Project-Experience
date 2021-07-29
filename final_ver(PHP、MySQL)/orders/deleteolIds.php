<?php
// require_once './checkSession.php';
session_start();
require_once '../db.inc.php';
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

$strId = join(",", $_POST['chk']);

//刪除數量
$count = 0;
$sql = "DELETE FROM `orders_List` WHERE  FIND_IN_SET(`oListId`, ? ) ";

$stmtDelete = $pdo->prepare($sql);
$stmtDelete->execute([$strId]);

if ($stmtDelete->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
}

$sqlOrder = "DELETE FROM `orders` WHERE `oId` NOT IN (SELECT `oId` FROM `orders_list`) ";
$stmtUpdate = $pdo->query($sqlOrder);
if ($stmtUpdate->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "已刪除訂單，返回列表";
    header("Refresh: 0; url = ./orders.php");
    // exit();
}
echo "<pre>";
print_r($stmtUpdate);
echo "</pre>";

header("Refresh: 1; url = ./orders.php");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
