<?php
require_once '../db.inc.php';

// 錯誤先行
$recyResult = [];
$recyResult["success"] = false;
$recyResult["info"] = "轉移至垃圾桶失敗，將返回主頁面。";

if (empty($_GET) || empty($_GET["chkIds"])) {
    header("Refresh:3; url=./partner.php");
    $recyResult["info"] = "無資料轉移，將返回主頁面。";
} else {
    // sql語法的部分
    $recyPartnerSql = "UPDATE `partners` SET `recycleIndex` = 1 WHERE FIND_IN_SET(`pId`, ?)";
    $recyPartnerStmt = $pdo->prepare($recyPartnerSql);
    $recyPartnerStmt->execute([$_GET["chkIds"]]);
    $recyNums = $recyPartnerStmt->rowCount();

    header("Refresh:3; url=./partner.php");
    if ($recyNums > 0) {
        $recyResult["success"] = true;
        $recyResult["info"] = "轉移成功，共轉移了{$recyNums}筆資料至垃圾桶，將返回主頁面。";
    }
}

echo json_encode($recyResult, JSON_UNESCAPED_UNICODE);
