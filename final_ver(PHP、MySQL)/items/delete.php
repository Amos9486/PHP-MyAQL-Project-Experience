<?php
// require_once('./checkSession.php');
require_once('../db.inc.php');

$sqlGetImg = "SELECT `iImg` FROM `items` WHERE `iId` = ? ";

$stmtGetImg = $pdo->prepare($sqlGetImg);
$arrGetImgParam = [(int)$_GET['iId']];
$stmtGetImg->execute($arrGetImgParam);

if ($stmtGetImg->rowCount() > 0) {
    $arrImg = $stmtGetImg->fetchAll()[0];
    if ($arrImg['iImg'] !== NULL) {
        @unlink('../files/' . $arrImg['iImg']);
    }
}

$sql = "DELETE FROM `items` WHERE `iId` = ? ";

$arrParam = [(int)$_GET['iId']];
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if ($stmt->rowCount() > 0) {
    header('Refresh: 2; url=./admin.php');
    echo "刪除成功";
} else {
    header('Refresh: 2; url=./admin.php');
    echo "刪除失敗，2秒後自動返回";
}
