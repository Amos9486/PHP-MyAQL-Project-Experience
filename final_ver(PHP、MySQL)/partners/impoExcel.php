<?php
require_once '../db.inc.php';
require_once '../vendor/autoload.php';

// 錯誤先行
$impoResult = [];
$impoResult["success"] = false;
$impoResult["info"] = "上傳失敗，將返回主頁面。";

// 先確認上傳內容是否存在
if ($_FILES["uploadExcel"]["error"] === 0) {
    // 接著移動上傳的檔案
    $fileName = "./files" . $_FILES["uploadExcel"]["name"];
    if (move_uploaded_file($_FILES["uploadExcel"]["error"], $fileName)) {
        // 最後將上傳的EXCEL轉存進資料庫
        // 讀取EXCEL
        $readFile = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileName);

        // 讀取工作表的資料列數
        $sheetRow = $readFile->getActiveSheet()->getHighestRow();

        // 依序讀取每一列
        for ($i = 2; $i <= $sheetRow; $i++) {
            // 排除有空值的列
            if ($readFile->getActiveSheet()->getCell('A' . $i)->getValue() === '' || $readFile->getActiveSheet()->getCell('A' . $i)->getValue() === null) break;

            // 讀取每個cell的值
        }
    }
} else {
    $impoResult["info"] = "無上傳資料，將返回主頁面。";
}

header("Refresh:3; url=./partner.php");
echo json_encode($impoResult, JSON_UNESCAPED_UNICODE);
