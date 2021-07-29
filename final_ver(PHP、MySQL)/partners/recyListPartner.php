<?php
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';

// 設定頁數
$perPage = isset($_COOKIE['choosePage']) ? $_COOKIE['choosePage'] : 5;
$totalData = $pdo->query('SELECT COUNT(1) FROM `partners` WHERE `recycleIndex` = 1')->fetch(PDO::FETCH_NUM)[0];
$totalPage = ceil($totalData / $perPage);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;

// 表單內容查詢
$dataSql = 'SELECT `pId` AS "流水號",`pAcco` AS "店家帳號",`pName` AS "店家姓名",`pPhone` AS "店家電話",`pAddr` AS "店家地址",`pDiscr` AS "店家描述",`created_at` AS "新增時間",`updated_at` AS "修改時間" 
            FROM `partners` 
            WHERE `recycleIndex` = 1
            LIMIT ?,?';
$pageArr = [($page - 1) * $perPage, $perPage];
$dataStmt = $pdo->prepare($dataSql);
$dataStmt->execute($pageArr);
$dataArr = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

// 將key值提取出來，轉存成值(新陣列)
if (!empty($dataArr)) {
    $headerKeys = array_keys($dataArr[0]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="./partnerCSS.css">
    <link rel="stylesheet" href="../svg.css">
</head>

<body>
    <!-- 設置刪除與還原 -->
    <span id="iconUndo"><a href="./undoPartner.php"><img src="../files/pics/undo2.svg" class="svgImg"></i></a></span>
    <span id="iconDel"><a href="./delPartner.php"><img src="../files/pics/delete2.svg" class="svgImg"></i></a></span>
    <?php if (!empty($dataArr)) { ?>
        <form action="" method="POST">
            <table>
                <thead class="tabh">
                    <tr>
                        <th>選擇</th>
                        <?php for ($i = 1; $i < count($headerKeys); $i++) { ?>
                            <th><?php echo $headerKeys[$i] ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="tabb">
                    <?php foreach ($dataArr as $k => $v) { ?>
                        <tr>
                            <td><?php echo "<input type='checkbox' name='recyChk[]' value='" . $v[$headerKeys[0]] . "' id='" . $v[$headerKeys[0]] . "'>" ?></td>
                            <?php
                            for ($i = 1; $i < count($v); $i++) { ?>
                                <td><?php echo $v[$headerKeys[$i]] ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <td colspan="8">
                        <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                            <?php echo "<a href='./partner.php?page={$i}'>{$i}</a>" ?>
                        <?php } ?>
                    </td>
                </tfoot>
            </table>
            <select name="choosePage" id="choosePage">
                <option value="<?php echo $perPage ?>"><?php echo $perPage ?></option>
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
            </select>
        </form>
    <?php
    } else {
        echo "<br>資料庫中沒有資料，請按上一頁返回。";
    }
    ?>
    <script src="./recyListPartner.js"></script>
</body>
</body>

</html>