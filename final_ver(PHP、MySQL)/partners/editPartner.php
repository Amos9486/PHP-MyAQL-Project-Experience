<?php
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';
$dataSql = 'SELECT `pAcco`,`pName`,`pPhone`,`pAddr`,`pDiscr`
            FROM `partners`
            WHERE `pId` = ?';
$dataStmt = $pdo->prepare($dataSql);
$dataStmt->execute([$_GET['pId']]);
$dataArr = $dataStmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./partnerCSS.css">
    <link rel="stylesheet" href="../svg.css">
</head>

<body>
    <form action="./editPartnerChk.php" method="POST">
        <table>
            <thead class="tabh">
                <tr>
                    <th>欄位名稱</th>
                    <th>店家帳號</th>
                    <th>店家名稱</th>
                    <th>店家電話</th>
                    <th>店家地址</th>
                    <th>店家描述</th>
                </tr>
            </thead>
            <tbody class="tabb">
                <tr>
                    <td>原始資料</td>
                    <?php foreach ($dataArr as $k => $v) { ?>
                        <td><?php echo $v ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>修改後資料</td>
                    <?php foreach ($dataArr as $k => $v) { ?>
                        <td><?php echo "<input type='text' name='{$k}'>" ?></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="pId" value="<?php echo $_GET['pId'] ?>">
        <input type="submit" value="送出修改">
    </form>
</body>

</html>