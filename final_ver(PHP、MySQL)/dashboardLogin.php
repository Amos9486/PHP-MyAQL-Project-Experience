<?php
//引用資料庫連線
require_once('./db.inc.php');

// 引用loading畫面
require_once('./loading.html');

//預設訊息
$loginResult['success'] = false;
$loginResult['info'] = "登入失敗";

if (isset($_POST['account']) && isset($_POST['pwd'])) {
    //SQL 語法
    $sql = "SELECT `aAct`, `aPwd`, `aName`
                    FROM `admin` 
                    WHERE `aAct` = ? 
                    AND `aPwd` = ? ";

    $arrParam = [
        $_POST['account'],
        sha1($_POST['pwd'])
    ];

    //取得資料庫內容
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    $arr = $stmt->fetch(PDO::FETCH_NUM);

    if ($stmt->rowCount() > 0) {
        header("Refresh: 5; url=./dashboard.php");

        session_start();
        $_SESSION['account'] = $arr[0];
        $_SESSION['name'] = $arr[2];

        $loginResult['success'] = true;
        $loginResult['info'] = "登入成功，3秒後自動進入頁面";
        // echo json_encode($loginResult, JSON_UNESCAPED_UNICODE);
        exit();
    }
} else {
    $loginResult['info'] = "請確實登入…3秒後自動回登入頁";
}

header("Refresh: 3; url=./index.php");
// echo json_encode($loginResult, JSON_UNESCAPED_UNICODE);
