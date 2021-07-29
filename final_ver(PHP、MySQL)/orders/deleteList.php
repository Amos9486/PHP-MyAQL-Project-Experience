<?php
// require_once './checkSession.php';
session_start();
require_once '../db.inc.php';

// echo "<pre>";
// print_r($_GET['oListId']);
// print_r($_GET['oId']);
// echo "</pre>";

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";
// header("Refresh: 0; url = ./orderList.php");


//刪除數量
if (!isset($_GET['oListId'])) {
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}
$sql = "DELETE FROM `orders_List` WHERE  FIND_IN_SET(`iId`, ? ) ";

$stmtDelete = $pdo->prepare($sql);
$stmtDelete->execute([$_GET['oListId']]);
if ($stmtDelete->rowCount() > 0) {
    header("Refresh: 0; url = ./orders.php");

    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
}

//查詢訂單內容商品單價、數量和總價
$newTotal = 0;
$sqlOrder = "SELECT `orders`.`oPrice`,`o`.`oId`, `o`.`oQty`, `o`.`oListPrice` FROM `orders_list` AS `o` LEFT JOIN `orders` ON `o`.`oId` = `orders`.`oId` WHERE `o`.`oId` = ? ";
$stmtEdit = $pdo->prepare($sqlOrder);
$stmtEdit->execute([$_GET['oId']]);
if ($stmtEdit->rowCount() > 0) {
    $newArr = $stmtEdit->fetchAll(PDO::FETCH_ASSOC);
    foreach ($newArr as $k => $v) {
        $newTotal += ($v['oListPrice'] * $v['oQty']);
    }
}
$newPriceArr = [$newTotal, $_GET['oId']];
$sqlNewPrice = "UPDATE `orders` SET `oPrice` = ? WHERE `oId` = ? ";
$stmtNewPrice = $pdo->prepare($sqlNewPrice);
$stmtNewPrice->execute($newPriceArr);

$sqlOrderFinal = "DELETE FROM `orders` WHERE `oId` NOT IN (SELECT `oId` FROM `orders_list`) ";
$stmtUpdate = $pdo->query($sqlOrderFinal);
if ($stmtUpdate->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "已刪除訂單，返回列表";
    header("Refresh: 1; url = ./orders.php");
    // exit();
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
//session_unset();