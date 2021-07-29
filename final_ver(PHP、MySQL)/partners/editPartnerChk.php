<?php
require_once '../db.inc.php';

// 錯誤先行
$editResult = [];
$editResult["success"] = false;
$editResult["info"] = "修改失敗，將返回主頁面。";

// 準備id資料以及空值判斷
$editTrigger = true;
$editPartnerArr = [];
$editPartnerArr[] = $_POST["pId"];
// 先移除pId，之後的foreach就不會影響到
unset($_POST["pId"]);

// sql語法的部分
$editPartnerSql = "UPDATE `partners` SET ";
foreach ($_POST as $k => $v) {
    if ($v !== "") {
        $editPartnerSql .= "`{$k}` = '{$v}' ,";
        $editTrigger = false;
    }
}

$editPartnerSql = substr($editPartnerSql, 0, -1) . " WHERE `pId` = ?";

if ($editTrigger) {
    header("Refresh:3; url=./partner.php");
    $editResult["info"] = "無任何修改，將返回主頁面。";
} else {

    $editPartnerStmt = $pdo->prepare($editPartnerSql);
    $editPartnerStmt->execute($editPartnerArr);

    header("Refresh:3; url=./partner.php");
    if ($editPartnerStmt->rowCount() > 0) {
        $editResult["success"] = true;
        $editResult["info"] = "修改成功，將返回主頁面。";
    }
}

echo json_encode($editResult, JSON_UNESCAPED_UNICODE);
