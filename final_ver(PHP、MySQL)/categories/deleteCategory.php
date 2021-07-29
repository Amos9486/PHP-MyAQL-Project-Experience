<?php
// require_once './checkSessionAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";
header("Refresh:3;url=./categories.php");
if (isset($_GET['deleteCategoryId'])) {
  $sql = "DELETE FROM `categories`
  WHERE `categoryId`= ?";
  $arrParam = [(int)$_GET['deleteCategoryId']];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($arrParam);
  if ($stmt->rowCount() > 0) {
    $objResponse['success'] = true;
    $objResponse['info'] = "刪除成功";
  }
} else {
  echo '刪除失敗';
}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
