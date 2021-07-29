<?php

// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");

$objResponse = [];
$objResponse["success"] = false;
$objResponse["info"] = "新增失敗";

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


$sql = "INSERT INTO `users`(`uAcco`,`uPwd`,`uName`,`uTWId`,`uBirth`,`uGender`,`uImg`,`uPhone`,`uMail`,`uAddr`,`uDiscr`)
    VALUES (?,?,?,?,?,?,?,?,?,?,?)";

// echo "<pre>";
// print_r($_POST["uPwd"]);
// echo "</pre>";


$NewPwd = sha1($_POST["uPwd"]);

//宣告一個空值才不會產生錯誤
$imgName = "";

if ($_FILES["uImg"]["error"] === 0) {
    // 判斷上傳成功與否
    $imgDate = date("YmdHis");
    $extension = pathinfo($_FILES["uImg"]["name"], PATHINFO_EXTENSION);
    $imgName = $imgDate . "." . $extension;

    // print_r($_FILES);
    // 照片實際路徑要對
    $moveImg = move_uploaded_file($_FILES["uImg"]["tmp_name"], "../files/" . $imgName);
} else {
    $objResponse["pictureNull"] = "照片無新增";
}

$arrParam = [
    $_POST["uAcco"],
    $NewPwd,
    $_POST["uName"],
    $_POST["uTWId"],
    $_POST["uBirth"],
    $_POST["uGender"],
    $imgName,
    $_POST["uPhone"],
    $_POST["uMail"],
    $_POST["uAddr"],
    $_POST["uDiscr"]

];

// echo "<pre>";
// echo print_r($arrParam);
// echo "</pre>";

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);
if ($stmt->rowCount() > 0) {
    $objResponse["success"] = true;
    $objResponse["info"] = "新增成功";
}

header("refresh:3;url=./account_user.php");
require_once("./loading.html");
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
