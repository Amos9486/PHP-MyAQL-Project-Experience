<?php
// require_once './checkSessionAdmin.php';
require_once '../db.inc.php';
$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "新增商品種類失敗";


if ($_POST['cateName'] === '') {
  header("Refresh:3;url=./categories.php");
  $objResponse['info'] = "請填寫商品種類名稱";
  echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
  exit();
}
if ($_POST['cateParentId'] === '') {
  header("Refresh:3;url=./categories.php");
  $objResponse['info'] = "請填寫上層編號";
  echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
  exit();
}


header("Refresh:3;url=./categories.php");
$sql = "INSERT INTO `categories`(`cateName`,`cateParentId`)
VALUES
(?,?)";
$stmt = $pdo->prepare($sql);

$stmt->execute([$_POST['cateName'], $_POST['cateParentId']]);
if ($stmt->rowCount() > 0) {
  $objResponse['success'] = true;
  $objResponse['info'] = "新增商品成功";
}
header("Refresh:3,url=./categories.php");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
