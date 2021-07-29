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
            <h1 class="hh1">Order By</h1>
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


        if (isset($_GET["orderForm"])) {
            switch ($_GET["orderForm"]) {
                case "ASC":
                    $sqlOrder = "SELECT* 
           FROM`users`
           ORDER BY `uBirth` ASC ";
                    break;

                case "DESC":
                    $sqlOrder = "SELECT* 
           FROM`users`
           ORDER BY `uBirth` DESC ";
                    break;
            }
        }


        // echo "<pre>";
        // print_r($arrParamOrder);
        // echo "</pre>";

        $stmtOrder = $pdo->query($sqlOrder);

        // echo "<pre>";
        // print_r($stmtOrder);
        // echo "</pre>";

        if ($stmtOrder->rowCount() > 0) {

            $arr = $stmtOrder->fetchAll();

            foreach ($arr as $K1 => $V1) { ?>
                <tr>
                    <?php foreach ($V1 as $K2 => $V2) { ?>
                        <?php if ($K2 == "uId" ||  $K2 == "created_at" || $K2 == "updated_at" || $K2 == "recycleIndex") {
                            continue; ?>
                        <?php } ?>
                        <?php if ($K2 == "uImg") { ?>
                            <td><img style="width:200px" src="./files/<?php echo $V2 ?>" alt=""></td>
                        <?php } else { ?><td><?php echo $V2 ?></td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            <?php  } ?>
        <?php  } ?>
        <?php /*echo "<pre>";
        print_r($arr);
        echo "</pre>";
        */ ?>

    </tbody>
</table>
<?php require_once("../footerMain.php") ?>