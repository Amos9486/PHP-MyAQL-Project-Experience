
<?php
session_start();

// require_once './checkSession.php';
require_once '../db.inc.php';


$objResponse = [];
$objResponse['success'] = false;
$objResponse['info'] = "加入商品失敗";
$objResponse['newItemNum'] = 0;


// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if (!isset($_POST)) {
    header("Refresh: 3; url=./new.php");
    $objResponse['info'] = "資料傳遞有誤";
    echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
    exit();
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        // print_r($v);
        // echo empty($v[0]);
        // echo "<br>";
        if (empty($v[0])) {
            continue;
        } else {
            $_SESSION['cart'][$k] = $v;
        }
    }

    // echo "<pre>SESSION";
    // print_r($_SESSION['cart']);
    // echo "</pre>";
    header("Refresh: 0; url=./new.php");
    $objResponse['success'] = true;
    $objResponse['info'] = "已加入購物車";
    $objResponse['newItemNum'] = count($_SESSION['cart']);
} else {
    header("Refresh: 3; url=./new.php");
    $objResponse['info'] = "查無商品項目";
    $objResponse['newItemNum'] = count($_SESSION['cart']);
}

echo json_encode($objResponse, JSON_UNESCAPED_UNICODE);
