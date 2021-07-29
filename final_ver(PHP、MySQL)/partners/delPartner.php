<?php
require_once '../db.inc.php';

// 錯誤先行
$delResult = [];
$delResult["success"] = false;
$delResult["info"] = "刪除失敗，將返回垃圾桶畫面。";

if (empty($_GET) || empty($_GET["chkIds"])) {
    header("Refresh:3; url=./recyListPartner.php");
    $delResult["info"] = "無刪除資料，將返回垃圾桶畫面。";
} else {
    // sql語法的部分
    $delPartnerSql = "DELETE FROM `partners` WHERE FIND_IN_SET(`pId`, ?)";
    $delPartnerStmt = $pdo->prepare($delPartnerSql);
    $delPartnerStmt->execute([$_GET["chkIds"]]);
    $delNums = $delPartnerStmt->rowCount();

    header("Refresh:3; url=./recyListPartner.php");
    if ($delNums > 0) {
        $delResult["success"] = true;
        $delResult["info"] = "刪除成功，共刪除了{$delNums}筆資料，將返回垃圾桶畫面。";
    }
}

echo json_encode($delResult, JSON_UNESCAPED_UNICODE);
