<?php
// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");
require_once("../headerMain.php");
require_once("../nav.php");
require_once("./adminTitle.php");
?>
<div class="container  mt-5 " style="min-width:100vw">
    <div class="row">
        <div class=" col-12 p-3 titlecolor text-white  mt-5 ">
            <h1 class="hh1">Garbage</h1>
        </div>
    </div>
</div>
<table style="min-width:100vw">
    <thead class="tabh">
        <tr>
            <th>帳號</th>
            <th>密碼</th>
            <th>姓名</th>
            <th>身份證字號</th>
            <th>出生年月日</th>
            <th>性別</th>
            <th>照片</th>
            <th>電話</th>
            <th>電子信箱</th>
            <th>地址</th>
            <th>簡介</th>
            <th colspan="2">備註</th>
        </tr>
    </thead>
    <tbody class="tabb">
        <?php
        $sql = "SELECT `uId`,`uAcco`,`uPwd`,`uName`,`uTWId`,`uBirth`,`uGender`,`uImg`,`uPhone`,`uMail`,`uAddr`,`uDiscr`
    FROM`users`
    WHERE `recycleIndex` = '1' ";

        $stmt = $pdo->query($sql);
        if ($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll();
            foreach ($arr as $K1 => $V1) { ?>
                <tr>
                    <?php foreach ($V1 as $K2 => $V2) {

                        if ($K2 == "uImg") { ?>
                            <td><img style="width:200px" src="../files/<?php echo $V2 ?>" alt=""></td>
                        <?php continue;
                        } ?>
                        <?php if ($K2 == "uId") { ?>
                        <?php continue;
                        } ?>
                        <td><?php echo $V2 ?></td>

                    <?php } ?>
                    <td><a href="./delete.php?uId=<?php echo $arr[$K1]["uId"] ?>">刪除</a></td>
                    <td><a href="./recycle.php?uId=<?php echo $arr[$K1]["uId"] ?>">還原</a></td>
                </tr>

            <?php } ?>

        <?php } else { ?>
            <tr>
                <td colspan="13">
                    <h2>垃圾桶已清空 </h2>
                </td>
            </tr>
        <?php } ?>


    </tbody>
</table>


<?php require_once("../footerMain.php"); ?>