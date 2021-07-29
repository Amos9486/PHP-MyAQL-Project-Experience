<?php
//傳送種類去找items的iCateId

// require_once './checkSession.php';
session_start();
require_once '../db.inc.php';

//錯誤先行
$objRespone = [];
$objRespone['success'] = false;
$objRespone['info'] = "無法搜尋";

//未取得表單送來的'categoryId'，則 show "查無種類"
if (!isset($_POST['categoryId'])) {
    header("Refresh: 3; url = ./new.php");
    $objRespone['info'] = "查無種類";
    echo json_encode($objRespone, JSON_UNESCAPED_UNICODE);
}

if (!isset($_SESSION['searchCate'])) $_SESSION['searchCate'] = [];

//$sql選出欲呈現的商品細則 (KEY)，以 array方式呈現並回傳./new.php
$sql = "SELECT `c`.`categoryId`, `i`.`iId`, `i`.`iName`, `i`.`iPrice`, `i`.`iQty` FROM `items` AS `i` LEFT JOIN `categories` AS `c` ON `i`.`iCateId` = `c`.`categoryId` WHERE `c`.`categoryId` = ?";
$stmt = $pdo->prepare($sql);

//表單送來的'categoryId'執行 execute，以陣列的形式 + 強制轉數值 (int)
$stmt->execute([(int)$_POST['categoryId']]);
$itemArr = $stmt->fetchAll();

//可用 print_r() 除錯或顯示array的結構

if ($stmt->rowCount() > 0) {
    $_SESSION["itemArr"] = $itemArr;
    header("Refresh: 0;url = ./new.php");
    $objRespone['success'] = true;
    $objRespone['info'] = "請新增商品";
    $objRespone['itemArr'] =  count($_SESSION['searchCate']);
} else {
    header("Refresh: 0;url = ./new.php");
    $objRespone['info'] = "請選擇種類";
    $objRespone['itemArr'] = count($_SESSION['searchCate']);
}

echo json_encode($objRespone, JSON_UNESCAPED_UNICODE);
