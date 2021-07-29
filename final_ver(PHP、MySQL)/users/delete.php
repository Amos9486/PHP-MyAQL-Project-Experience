<?php
// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");

$objResponse = [];
$objResponse["success"] = false;
$objResponse["info"] = "丟入失敗";


$sqlImg = "SELECT `uImg`
        FROM `users`
        WHERE `uId`= ? ";

$arrImg = [$_GET["uId"]];

// echo "<pre>";
// print_r($arrImg);
// echo "</pre>";

$stmtImg = $pdo->prepare($sqlImg);

// echo "<pre>";
// print_r($stmtImg);
// echo "</pre>";

$stmtImg->execute($arrImg);
if ($stmtImg->rowCount() > 0) {
    $arr = $stmtImg->fetchAll()[0];
    if ($arr["uImg"] !== "") {
        @unlink("../files/" . $arr["uImg"]);
    }
}
$sql = "DELETE FROM `users`
        WHERE `uId`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute($arrImg);
if ($stmt->rowCount() > 0) {
    $objResponse["success"] = true;
    $objResponse["info"] = "刪除成功";
}

header("refresh:3;url=./garbage.php");
require_once("./loading.html");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
