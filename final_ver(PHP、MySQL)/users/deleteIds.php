<?php
// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");

$objResponse = [];
$objResponse["success"] = false;
$objResponse["info"] = "刪除失敗";
// 錯誤先行

if (isset($_POST["chk"])) {

    // echo "<pre>";
    // print_r($_POST["chk"]);
    // echo "</pre>";
    // 要點擊勾選項$_POST["chk"]才會有值

    $strId = join(",", $_POST["chk"]);
    // 將所有id 透過join結合，並顯示1,2,3
    // $strId為勾選的資料筆數

    // echo "<pre>";
    // print_r($strId);
    // echo "</pre>";

    $count = 0;
    //紀錄要刪除的資料筆數

    $sqlImg = "SELECT `uImg`
           FROM `users`
           WHERE FIND_IN_SET(`uId`,?)";
    //FIND_IN_SET 查詢多筆(將id 轉成array 形式)id 並找出資料欄位的照片名稱

    $arrId[] = $strId;
    //將$strId為勾選的資料筆數  轉為 array

    $stmtImg = $pdo->prepare($sqlImg);

    $stmtImg->execute($arrId);

    // 確認是否有勾選要刪除的資料
    if ($stmtImg->rowCount() > 0) {
        $arr = $stmtImg->fetchall();
        // **用迴圈列出所有照片**
        for ($i = 0; $i < count($arr); $i++) {
            // 刪已存在的照片
            if ($arr[$i]["uImg"] !== NULL) {
                // @unlink("./files/{$arr[$i]["uImg"]}");
                @unlink("../files/" . $arr[$i]["uImg"]);
            }
        }
        // 確認已有資料後，再下sql 刪除文字部分
        $sql = "DELETE FROM `users` 
       WHERE  FIND_IN_SET (`uId`,?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrId);
        // 要顯示總共刪幾筆
        $count = $stmt->rowCount();
        $objResponse["success"] = true;
        $objResponse["info"] = "刪除成功，總共刪除：{$count}筆";
    }
}

header("refresh:3;url=./account_user.php");
require_once("./loading.html");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
