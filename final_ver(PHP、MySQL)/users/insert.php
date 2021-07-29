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
            <h1 class="hh1">Insert</h1>
        </div>
    </div>
</div>


<form name="myForm" method="post" action="./insertback.php" enctype="multipart/form-data">
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
            </tr>
        </thead>
        <tbody class="tabb">
            <tr>
                <td><input type="text" name="uAcco" vaiue="" maxlength="20"></td>
                <td><input type="text" name="uPwd" vaiue="" maxlength="50"></td>
                <td><input type="text" name="uName" vaiue="" maxlength="20"></td>
                <td><input type="text" name="uTWId" vaiue="" maxlength="10"></td>
                <td><input type="text" name="uBirth" vaiue=""></td>
                <td><input type="text" name="uGender" vaiue="" maxlength="5"></td>
        </tbody>
        <thead class="tabh">
            <tr>
                <th>照片</th>
                <th>電話</th>
                <th>電子信箱</th>
                <th>聯絡地址</th>
                <th>簡介</th>
            </tr>
        </thead>
        <tbody class="tabb">
            <tr>
                <!-- Img 新增要用 input type=file  -->
                <td><input type="file" name="uImg" maxlength="50"></td>
                <td><input type="text" name="uPhone" vaiue="" maxlength="10"></td>
                <td><input type="text" name="uMail" vaiue="" maxlength="100"></td>
                <td><input type="text" name="uAddr" vaiue="" maxlength="50"></td>
                <td><textarea name="uDiscr" vaiue=""></textarea></td>
            </tr>
        </tbody>

    </table>

    <input type="hidden" name="uId" value="">
    <input class="my-2 " type="submit" name="smb" value="新增">
</form>



<?php require_once("../footerMain.php") ?>