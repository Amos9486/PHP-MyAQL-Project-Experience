<?php
require_once '../db.inc.php';

// 錯誤先行
$undoResult = [];
$undoResult["success"] = false;
$undoResult["info"] = "還原失敗，將返回垃圾桶畫面。";

if (empty($_GET) || empty($_GET["chkIds"])) {
    header("Refresh:3; url=./recyListPartner.php");
    $undoResult["info"] = "無還原資料，將返回垃圾桶畫面。";
} else {
    // sql語法的部分
    $undoPartnerSql = "UPDATE `partners` SET `recycleIndex` = 0 WHERE FIND_IN_SET(`pId`, ?)";
    $undoPartnerStmt = $pdo->prepare($undoPartnerSql);
    $undoPartnerStmt->execute([$_GET["chkIds"]]);
    $undoNums = $undoPartnerStmt->rowCount();

    header("Refresh:3; url=./recyListPartner.php");
    if ($undoNums > 0) {
        $undoResult["success"] = true;
        $undoResult["info"] = "還原成功，共還原了{$undoNums}筆資料，將返回垃圾桶畫面。";
    }
}

echo json_encode($undoResult, JSON_UNESCAPED_UNICODE);
