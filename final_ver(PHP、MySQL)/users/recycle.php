<?php
// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");

$objResponse = [];
$objResponse["success"] = false;
$objResponse["info"] = "還原失敗";

if (isset($_GET["uId"])) {
    $sqlRecycle = "UPDATE `users`
SET`recycleIndex`= 0
WHERE `uId`=?";
    $arrParam = [$_GET["uId"]];
    $stmtRecycle = $pdo->prepare($sqlRecycle);
    $stmtRecycle->execute($arrParam);
    if ($stmtRecycle->rowCount() > 0) {
        $objResponse["success"] = true;
        $objResponse["info"] = "還原成功";
    }
}

header("refresh:3;url=./garbage.php");
require_once("./loading.html");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
