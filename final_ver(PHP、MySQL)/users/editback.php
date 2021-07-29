<?php
// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");

$objResopnse = [];
$objResponse["success"] = false;
$objResponse["info"] = "編輯失敗";

$regex = "/[A-Z](1|2)[0-9]+/";
$regexMail = "/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/";
if (preg_match($regex, $_POST["uTWId"], $match) && preg_match($regexMail, $_POST["uMail"], $match)) {
    $objResponse["success"] = true;
    $objResponse["regex"] = "身份證字號及電子信箱驗證成功";
} else {

    header("refresh:3;url=./account_user.php");

    $objResponse["success"] = false;
    $objResponse["TWId"] = "身份證字號或電子信箱驗證失敗";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}



$sql = "UPDATE `users`
SET`uAcco`=?,
`uName`=?,
`uTWId`=?,
`uBirth`=?,
`uGender`=?,
`uPhone`=?,
`uMail`=?,
`uAddr`=?,
`uDiscr`=?";

$arrParam = [
    $_POST["uAcco"],
    $_POST["uName"],
    $_POST["uTWId"],
    $_POST["uBirth"],
    $_POST["uGender"],
    $_POST["uPhone"],
    $_POST["uMail"],
    $_POST["uAddr"],
    $_POST["uDiscr"]
];

$newPwd = sha1($_POST["uPwd"]);

$sql .= ",";
$sql .= "`uPwd`=?";
$arrParam[] = $newPwd;
// $_FILES["uImg"]是新的照片
// 上傳成功
if ($_FILES["uImg"]["error"] === 0) {
    $imgDate = date("YmdHis");
    $extension = pathinfo($_FILES["uImg"]["name"], PATHINFO_EXTENSION);
    $imgName = $imgDate . "." . $extension;
    // 用新照片要移動至實際存放位置時判斷是否存在舊照片資訊
    if (move_uploaded_file($_FILES["uImg"]["tmp_name"], "../files/" . $imgName)) {
        // 找舊照片資訊
        $sqlImg = "SELECT `uImg`
FROM `users`
WHERE `uId`=?";
        $arrImg = [$_POST["uId"]];
        $stmtImg = $pdo->prepare($sqlImg);
        $stmtImg->execute($arrImg);
        if ($stmtImg->rowCount() > 0) {
            $arr = $stmtImg->fetchAll()[0];
            if ($arr["uImg"] !== NULL) {
                //刪除找到的舊照片資訊
                @unlink("../files/" . $arr["uImg"]);
            }
            $sql .= ",";
            $sql .= "`uImg`=?";
            $arrParam[] = $imgName;
        }
    }
}
// sql 語法 空白鍵要注意 $sql .= "(空白鍵)WHERE `uId`=?";
$sql .= " WHERE `uId`=?";
$arrParam[] = (int)$_POST["uId"];

// print_r($sql);


$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {

    $objResponse["success"] = true;
    $objResponse["info"] = "編輯成功";
}
header("refresh:3;url=./account_user.php");
require_once("./loading.html");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
