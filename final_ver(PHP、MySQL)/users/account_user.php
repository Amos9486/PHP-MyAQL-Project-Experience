<?php
// require_once("./checkSessionAdmin.php");
require_once("../db.inc.php");
require_once("../headerMain.php");
require_once("../nav.php");
require_once("./adminTitle.php");


$sqlPage = "SELECT count(1) AS `count` 
FROM `users`
WHERE`recycleIndex` = 0
";

$stmtPage = $pdo->query($sqlPage);

$arrPage = $stmtPage->fetchall()[0];

$dataBase = $arrPage["count"]; //資料總筆數=key[欄位名稱]***

$_GET["selectPage"] = !isset($_GET["selectPage"]) ? 5 : $_GET["selectPage"];
//要先預設$_GET["selectPage"]=5，不然顯示會報錯
?>
<!-- 每頁顯示資料筆數功能  onChange="submit()"可以直接選擇後執行 -->
<form action="" method="GET" class="my-5">
    <label for="selectPage">每頁顯示:</label>
    <select name="selectPage" id="selectPage" onChange="submit()">
        <option value="#" selected>請選擇</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="<?php echo $dataBase ?>">All</option>
    </select>筆

</form>
<!--  跳頁式下拉選單功能 onchange="location = this.options[this.selectedIndex].value;"  -->


<?php

// print_r($_POST); 確認post 是否有存入

// $_COOKIE["set"] = isset($_COOKIE["set"]) ? $_COOKIE["set"] : setcookie("set", "5", time() + 3600);
// if (!isset($_COOKIE["set"])) {
//     setcookie("set", "5", time() + 3600);
// }
// echo !isset($_COOKIE["set"]);確認cookie 是否有存入
// if (isset($_GET["selectPage"])) {
// header("refresh:1;");
// 刷新頁面 url ($_POST要刷新頁面)不要填才能留cookie & post
// setcookie("set", $_GET["selectPage"], time() + 3600);
// <script>
//     window.onload = function() {
//         document.getElementById('selectPage').click();
//     }
// </script>

// print_r($_COOKIE);
// }
// print_r($_GET);
// *****重點：用$_COOKIE 傳值會有延遲的問題，用$_POST傳值會有需refresh 的問題，用$_GET傳值會有網址的問題*****
// settype() 可確認型態


//$NumPage = isset($_COOKIE["set"]) ? $_COOKIE["set"] : 5; //一頁幾筆

// print_r($_GET); 
// print_r($NumPage); 

$NumPage = isset($_GET["selectPage"]) ? $_GET["selectPage"] : 5;

// print_r($NumPage);

$ResultPage = ceil($dataBase / (int)$NumPage);

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;

$page =  $page < 0 ? 1 : $page;

?>



<!-- action deleteId -->
<!-- cellpadding="8" table的屬性 表格的內距 -->
<div class="container  mt-5 " style="min-width:100vw">
    <div class="row">
        <div class=" col-12 p-3 titlecolor text-white  mt-5 ">
            <h1 class="hh1">Users</h1>
        </div>
    </div>
</div>

<div class=" bg-light pb-3 " style="min-width: 100vw">
    <div class="pt-3 ">
        <form name="myForm" method="post" action="./deleteIds.php" enctype="multipart/form-data">
            <input class="my-2" type="submit" name="smb" value="多選刪除">

            <table>
                <thead class="tabh">
                    <tr>
                        <th>選擇</th>
                        <th>編輯</th>
                        <th>帳號</th>
                        <th>姓名</th>
                        <th>身份證字號</th>
                        <th>出生年月日</th>
                        <th>性別</th>
                        <th>照片</th>
                        <th>電話</th>
                        <th>電子信箱</th>
                        <th>地址</th>
                        <th>簡介</th>
                        <th>新增時間</th>
                        <th>備註</th>
                    </tr>
                </thead>
                <tbody class="tabb">
                    <?php
                    $sql = "SELECT `uId`,`uAcco`,`uPwd`,`uName`,`uTWId`,`uBirth`,`uGender`,`uImg`,`uPhone`,`uMail`,`uAddr`,`uDiscr`,`recycleIndex`,`created_at`
                                    FROM `users`
                                    WHERE`recycleIndex` = 0
                                ORDER BY `uId` ASC
                                LIMIT ?,? ";
                    $arrParam = [($page - 1) * $NumPage, $NumPage];
                    // echo "<pre>";
                    // print_r($_SESSION["uAct"]);
                    // echo "</pre>";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($arrParam);
                    if ($stmt->rowCount() > 0) {

                        $arr = $stmt->fetchall();

                        // echo "<pre>";
                        // print_r($arr[0]["recycleIndex"]);
                        // echo "</pre>";
                        // echo gettype($arr[0]["recycleIndex"]);

                        for ($i = 0; $i < count($arr); $i++) {
                            if ($arr[$i]["recycleIndex"] !== 0) {
                                continue; ?>
                            <?php } else { ?>
                                <tr>
                                    <td><input type="checkbox" name="chk[]" value="<?php echo $arr[$i]["uId"] ?>"></td>
                                    <td><a href="./edit.php?uId=<?php echo $arr[$i]["uId"] ?>">編輯</a></td>
                                    <td><?php echo $arr[$i]["uAcco"] ?></td>
                                    <!-- <td><?php //echo $arr[$i]["uPwd"] 
                                                ?></td> -->

                                    <td><?php echo $arr[$i]["uName"] ?></td>
                                    <td><?php echo $arr[$i]["uTWId"] ?></td>
                                    <td><?php echo $arr[$i]["uBirth"] ?></td>
                                    <td><?php echo $arr[$i]["uGender"] ?></td>
                                    <!-- 照片要用img 呈現  -->
                                    <td><?php if ($arr[$i]["uImg"] !== NULL) { ?> <img src="../files/<?php echo $arr[$i]["uImg"] ?>" alt="" style="width:200px"> <?php } ?></td>
                                    <td><?php echo $arr[$i]["uPhone"] ?></td>
                                    <td><?php echo $arr[$i]["uMail"] ?></td>
                                    <td style="width:100px"><?php echo $arr[$i]["uAddr"] ?></td>
                                    <td><?php echo $arr[$i]["uDiscr"] ?></td>
                                    <td><?php echo $arr[$i]["created_at"] ?></td>
                                    <!-- 編輯及刪除鍵 帶 uId -->
                                    <td><a href="./garbageback.php?uId=<?php echo $arr[$i]["uId"] ?>">丟入垃圾桶</a></td>
                                </tr>
                            <?php } ?>
                        <?php  } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="15">無資料</td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <?php
                        if (($page - 1) > 0) { ?>
                            <td class="td-block"><a href="./account_user.php?page=<?php echo $page - 1 ?>&selectPage=<?php echo $_GET["selectPage"] ?>">上一頁</a></td><?php } ?>
                        <!-- page 鍵  用迴圈 -->
                        <td class="td-block" colspan="15"><?php for ($i = 1; $i <= $ResultPage; $i++) { ?>
                                <a href="./account_user.php?page=<?php echo $i ?>&selectPage=<?php echo $_GET["selectPage"] ?>"><?php echo $i ?> </a>
                            <?php } ?>
                        </td>
                        <?php if (($page + 1) <= $ResultPage) { ?>
                            <td class="td-block"><a href="./account_user.php?page=<?php echo $page + 1 ?>&selectPage=<?php echo $_GET["selectPage"] ?>">下一頁</a></td><?php }  ?>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>

<form action="">
    <select style="width:150px;" onchange="location = this.options[this.selectedIndex].value;">
        <option value="#">請選擇頁數</option>
        <?php for ($i = 1; $i <= $ResultPage; $i++) { ?>
            <option value="./account_user.php?page=<?php echo $i ?>&selectPage=<?php echo $_GET["selectPage"] ?>">
                <?php echo "第" . $i . "頁" ?>
            </option>
        <?php } ?>
    </select>
</form>


<?php require_once("../footerMain.php"); ?>