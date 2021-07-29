<?php
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';
$dataSql = 'SELECT `pAcco`,`pPwd`,`pName`,`pPhone`,`pAddr`,`pDiscr`
            FROM `partners`';
$dataArr = $pdo->query($dataSql)->fetch();
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
    <form action="./newPartnerChk.php" method="POST">
        <table>
            <thead class="tabh">
                <tr>
                    <th>欄位名稱</th>
                    <th>店家帳號</th>
                    <th>店家密碼</th>
                    <th>店家名稱</th>
                    <th>店家電話</th>
                    <th>店家地址</th>
                    <th>店家描述</th>
                </tr>
            </thead>
            <tbody class="tabb">
                <tr>
                    <td>欄位內容</td>
                    <?php foreach ($dataArr as $k => $v) { ?>
                        <td><?php echo "<input type='text' name='{$k}'>" ?></td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="新增">
    </form>
</body>

</html>