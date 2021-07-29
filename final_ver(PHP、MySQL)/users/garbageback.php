<?php
// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");

$objResponse = [];
$objResponse["success"] = false;
$objResponse["info"] = "丟入垃圾桶失敗";
if (isset($_GET["uId"])) {
    $sql = "UPDATE `users` 
SET`recycleIndex`= 1
WHERE `uId`= ? ";

    $arrParam = [$_GET["uId"]];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    if ($stmt->rowCount() > 0) {
        header("refresh:3;url=./account_user.php");
        require_once("./loading.html");
        $objResponse["success"] = true;
        $objResponse["info"] = "丟入垃圾桶成功";
        echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    }
}
