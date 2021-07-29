<?php
// require_once './checkSessionAdmin.php';
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "刪除失敗";

if ($_POST['cateName'] === "") {
  header("Refresh:3;url=./editCategory.php?editCategoryId={$_POST['editCategoryId']}");
  $objResponse['info'] = "請填寫商品種類";
  echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
  exit();
}

// if ($_POST['cateParentId'] === "") {
//   header("Refresh:3;url=./editCategory.php?editCategoryId={$_POST['editCategoryId']}");
//   $objResponse['info'] = "請填寫商品編號";
//   echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
//   exit();
// }

$sql = "UPDATE `categories`
SET 

`cateName`=?,
`cateParentId`=?
WHERE
`categoryId`=?
";
$stmt = $pdo->prepare($sql);
$arrParam = [$_POST['cateName'], $_POST['cateParentId'], (int)$_POST['editCategoryId']];
$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {
  $objResponse['success'] = true;
  $objResponse['info'] = "編輯成功";
}
header("Refresh:3;url=./categories.php");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
