<?php
// require_once './checkSession.php';
session_start();
require_once '../db.inc.php';

$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = '新增訂單失敗';

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// echo "<pre>";
// print_r($_POST['uAcco']);
// echo "</pre>";

$count = 0;

try{
    $pdo->beginTransaction();
    $sqlOrder = "INSERT INTO `orders` (`uAcco`, `oPrice`) VALUES (?, ?) ";
    $arr = [$_POST['uAcco'], $_POST['totalPrice']];
    $stmt = $pdo->prepare($sqlOrder);
    $stmt->execute($arr);
    // echo "<pre>";
    // print_r($stmt);
    // echo "</pre>";

    $oId = $pdo->lastInsertId();

    $sqlItemList = "INSERT INTO `orders_list`(`oId`, `iId`,`oListName`,  `oQty`, `oListPrice`) VALUES (?, ?, ?, ?, ? ) ";
    $stmtItemList = $pdo->prepare($sqlItemList);
    for($i=0; $i<count($_POST['chk1']);$i++){
        $arrOrder = [
            $oId,
            $_POST['chk1'][$i],
            $_POST['oListName'][$i],
            $_POST['oQty'][$i],
            $_POST['oListPrice'][$i],
        ];

        $stmtItemList->execute($arrOrder);
        $count += $stmtItemList->rowCount();
    }
    // echo "<pre>";
    // print_r($stmtItemList);
    // echo "</pre>";
    $pdo->commit();
}catch (PDOException $e){
    $pdo->rollBack();
}

    header("Refresh: 0; url = ./new.php");
if($count>0){
    unset($_SESSION['cart']);
    unset($_SESSION['itemArr']);

    $objResponse['success'] =true;
    $objResponse['info'] ="訂單新增成功";

}
echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);

