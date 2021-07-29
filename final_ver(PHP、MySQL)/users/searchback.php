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
            <h1 class="hh1">Search</h1>
        </div>
    </div>
</div>

<table>
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
        </tr>
    </thead>

    <tbody class="tabb">


        <?php
        // print_r($_GET["inputSearch"]);
        // echo isset($_GET["inputSearch"]);

        if (isset($_GET['inputSearch']) && $_GET['inputSearch'] !== "") {
            $sqlSearch = "SELECT* 
FROM users
WHERE `uAcco` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uPwd` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uName` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uTWId` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uBirth` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uGender` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uMail` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uAddr` LIKE '%" . $_GET['inputSearch'] . "%'
OR `uDiscr` LIKE '%" . $_GET['inputSearch'] . "%'
";

            // echo !isset($sqlSearch);
            // print_r($stmtSearch);

            $stmtSearch = $pdo->query($sqlSearch);


            // print_r($stmtSearch);

            if ($stmtSearch->rowCount() > 0) {


                $arrSearchResult = $stmtSearch->fetchAll(); ?>
                <?php /*echo "<pre>";
                 print_r($arrSearchResult);
                 echo "</pre>";
                foreach ($arrSearchResult as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v2) { ?>
                        <tr>
                            <td><?php echo $v2; ?></td>
                        </tr>

                    <?php } ?>
                <?php }*/ ?>
                <!-- foreach 第一次為$k1=[0]、$V1=陣列名稱 第二次為$2=欄位名稱、$v2=欄位內容的值 -->


                <?php for ($j = 0; $j < count($arrSearchResult); $j++) {
                ?><tr>
                        <td><?php echo $arrSearchResult[$j]["uAcco"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uPwd"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uName"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uTWId"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uBirth"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uGender"]; ?></td>
                        <td><img src="./files/<?php echo $arrSearchResult[$j]["uImg"]; ?>" alt=""></td>
                        <td><?php echo $arrSearchResult[$j]["uPhone"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uMail"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uAddr"]; ?></td>
                        <td><?php echo $arrSearchResult[$j]["uDiscr"]; ?></td>
                    </tr>
                <?php } ?>
            <?php } else {
                header("refresh:3;url=./account_user.php"); ?>
                <tr>
                    <td colspan="13">
                        <h2>無搜尋到相關資料 </h2>
                    </td>
                </tr>
            <?php } ?>

        <?php } else {
            header("refresh:3;url=./account_user.php"); ?>
            <tr>
                <td colspan="13">
                    <h2>請輸入搜尋關鍵字 </h2>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<?php require_once("../footerMain.php"); ?>