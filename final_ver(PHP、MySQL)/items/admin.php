<?php
// require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('../headerMain.php');
require_once('../nav.php');

// SQL 語法: 取得 items 資料表總筆數
$sqlTotal = "SELECT COUNT(1) AS `count` FROM `items`";

// 用 PDO 中的 query 方法執行 SQL 語法，並回傳、建立 PDOstatment 物件 $stmtTotal
$stmtTotal = $pdo->query($sqlTotal);

// 用 PDOstatement 中的 fetchAll 方法取得第一筆資料回傳給 $arrTotal
$arrTotal = $stmtTotal->fetchAll()[0];

// 將第一筆資料中取得的資料表總筆數傳給 $total
$total = $arrTotal['count'];

// 設定每頁有 5 筆資料
$numPerPage = 5;

// 用 ceil() 無條件進位(大於該數值的最小整數)計算總頁數
$totalPages = ceil($total / $numPerPage);

// 判斷自訂頁數是否存在，若存在回傳當下頁數，若無便回傳第 1 頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 若自訂頁數小於 1 回傳第 1 頁，若無便回傳當下自訂頁數
$page = $page < 1 ? 1 : $page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .border {
        border: 1px solid;
    }

    .iImg {
        width: 300px;
    }
</style>

<body>
    <?php require_once('./templates/title.php'); ?>

    <table class="border">
        <thead class="tabh">
            <tr>
                <th class="border">商品分類</th>
                <th class="border">商品編號</th>
                <th class="border">商品名稱</th>
                <th class="border">商品圖片</th>
                <th class="border">商品簡介</th>
                <th class="border">商品數量</th>
                <th class="border">商品價格</th>
                <th class="border">功能</th>
            </tr>
        </thead>
        <tbody class="tabb">
            <?php
            // SQL 語法: 取得 items 資料表用 iId 排列
            $sql = "SELECT `iCateId`, `iId`, `iName`, `iImg`, `iDiscr`, `iQty`, `iPrice`
                FROM `items`
                ORDER BY `iId` ASC
                LIMIT ?, ?";

            $arrParam = [($page - 1) * $numPerPage, $numPerPage];

            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            if ($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll();
                for ($i = 0; $i < count($arr); $i++) {
            ?>
                    <tr>
                        <td class="border">
                            <?php echo $arr[$i]['iCateId']; ?>
                        </td>

                        <td class="border">
                            <?php echo $arr[$i]['iId']; ?>
                        </td>

                        <td class="border">
                            <?php echo $arr[$i]['iName']; ?>
                        </td>

                        <td class="border">
                            <img class="iImg" src="../files/<?php echo $arr[$i]['iImg']; ?>">
                        </td>

                        <td class="border">
                            <?php echo $arr[$i]['iDiscr']; ?>
                        </td>

                        <td class="border">
                            <?php echo $arr[$i]['iQty']; ?>
                        </td>

                        <td class="border">
                            <?php echo $arr[$i]['iPrice']; ?>
                        </td>

                        <td class="border">
                            <a href="edit.php?iId=<?php echo $arr[$i]['iId']; ?>">編輯</a>
                            <a href="delete.php?iId=<?php echo $arr[$i]['iId']; ?>">刪除</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="border td-block" colspan="8">
                    <?php
                    for ($i = 1; $i <= $totalPages; $i++) {
                    ?>
                        <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php require_once("../footerMain.php"); ?>