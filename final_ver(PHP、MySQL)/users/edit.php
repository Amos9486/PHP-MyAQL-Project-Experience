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
            <h1 class="hh1">Edit</h1>
        </div>
    </div>
</div>

<div class=" bg-light pb-3 " style="min-width: 100vw;">
    <div class="pt-3 ">

        <form name="myForm" method="post" action="./editback.php" enctype="multipart/form-data">
            <!-- cellpadding="8" table的屬性 表格的內距 -->
            <table>
                <thead class="tabh">
                    <tr>
                        <th>帳號</th>
                        <th>密碼<br>(請輸入原始密碼)</th>
                        <th>姓名</th>
                        <th>身份證字號<br>(開頭英文字母請大寫)</th>
                        <th>出生年月日<br>(請輸入西元年、月、日)</th>
                        <th>性別</th>
                        <th>照片</th>
                        <th>電話</th>
                        <th>電子信箱</th>
                        <th>地址</th>
                        <th>簡介</th>
                    </tr>
                </thead>
                <tbody class="tabb">
                    <tr>
                        <?php
                        $sql = "SELECT `uId`,`uAcco`,`uPwd`,`uName`,`uTWId`,`uBirth`,`uGender`,`uImg`,`uPhone`,`uMail`,`uAddr`,`uDiscr`
                    FROM `users`
                    WHERE `uId`=? ";
                        $arrParam = [$_GET["uId"]];
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($arrParam);
                        if ($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchall()[0]; ?>
                            <td><input type="text" name="uAcco" value="<?php echo $arr["uAcco"] ?>" maxlength="20"></td>
                            <td><input type="text" name="uPwd" value="<?php echo $arr["uPwd"] ?>" maxlength="50"></td>
                            <td><input type="text" name="uName" value="<?php echo $arr["uName"] ?>" maxlength="20"></td>
                            <td><input type="text" name="uTWId" value="<?php echo $arr["uTWId"] ?>" maxlength="10"></td>
                            <td><input type="text" name="uBirth" value="<?php echo $arr["uBirth"] ?>"></td>
                            <td>

                                <input type="radio" name="uGender" value="男">男
                                <input type="radio" name="uGender" value="女">女


                            </td>
                            <td>
                                <p>原照片</p> <img src="../files/<?php echo $arr["uImg"] ?>" alt="" style="width:200px"><input type="file" name="uImg" value="<?php echo $arr["uImg"] ?>" maxlength="50">
                            </td>
                            <td><input type="text" name="uPhone" value="<?php echo $arr["uPhone"] ?>" maxlength="10"></td>
                            <td><input type="text" name="uMail" value="<?php echo $arr["uMail"] ?>" maxlength="100"></td>
                            <td><input type="text" name="uAddr" value="<?php echo $arr["uAddr"] ?>" maxlength="50"></td>
                            <td><textarea name="uDiscr" value="<?php echo $arr["uDiscr"] ?>" style="width:200px"></textarea></td>

                        <?php } ?>
                    </tr>
                </tbody>
            </table>

            <input type="hidden" name="uId" value="<?php echo $_GET["uId"]; ?>">
            <input class="my-2" type="submit" name="smb" value="編輯">
        </form>

    </div>
</div>



<?php require_once("../footerMain.php") ?>