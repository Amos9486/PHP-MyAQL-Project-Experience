<?php
require_once '../db.inc.php';

// 錯誤先行
$newResult = [];
$newResult["success"] = false;
$newResult["info"] = "新增失敗，3秒後返回主頁面。";

// 將sql語法拆成兩段處理
$newSqlPart1 = "INSERT INTO `partners` (";
$newSqlPart2 = ") VALUE (";

$newPartnerArr = [];
foreach ($_POST as $k => $v) {
    if ($v !== "") {
        $newSqlPart1 .= "`{$k}`,";
        $newSqlPart2 .= "?,";
        if ($k == "pPwd") {
            $newPartnerArr[] = sha1($v);
        } else {
            $newPartnerArr[] = $v;
        }
    }
}

if (empty($newPartnerArr)) {
    header("Refresh:3; url=./partner.php");
    $newResult["info"] = "請確實填寫資料，3秒後返回主頁面。";
} else {
    $newPartnerSql = substr($newSqlPart1, 0, -1) . substr($newSqlPart2, 0, -1) . ")";

    $newPartnerStmt = $pdo->prepare($newPartnerSql);
    $newPartnerStmt->execute($newPartnerArr);

    header("Refresh:3; url=./partner.php");
    if ($newPartnerStmt->rowCount() > 0) {
        $newResult["success"] = true;
        $newResult["info"] = "新增成功，3秒後返回主頁面。";
    }
}

echo json_encode($newResult, JSON_UNESCAPED_UNICODE);
