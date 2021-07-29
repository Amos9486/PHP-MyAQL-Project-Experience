<!-- 
    1. 選擇商品種類後，使用者帳號會被重整刷掉; 且商品種類無法停留在原選項中
    2. 缺少商品細則 <input type="text">點擊連動<input type ="checkbox">的功能
 -->

<?php
// require_once '../checkSession.php';
session_start();
// session_unset();
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';
?>

    <!-- nav -->
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <div class="row justify-content-center">
                <div class="d-flex justify-content-space">
                    <!-- <div>
                            <h3 class="">賣家後台</h3>
                        </div> -->
                    <div class="d-flex flex-row align-self-end">
                        <li class="nav-item">
                            <a class="nav-link " href="./orders.php">訂單總表</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link " href="./orderList.php">訂單詳情</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="./edit.php">訂單修改</a>
                        </li> -->
                        <li class="nav-item">
                            <a a class="nav-link active" href="./new.php">新增訂單</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="./state.php">訂單狀態</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="./logout.php">登出</a>
                        </li> -->
                    </div>
                </div>
            </div>

        </ul>
    </div>
    <h3>新增訂單</h3>



    <!-- 商品種類選擇表單 -->
    <form name="myForm" method="POST" enctype="multipart/form-data" action="./searchItem.php">



        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">商品種類</label>
        <select name="categoryId" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" onchange="submit()">
            <?php
            $sqlCate = "SELECT `categoryId`, `cateName` FROM `categories` WHERE `cateParentId` != 0 ";
            $stmtcateId = $pdo->query($sqlCate);
            if ($stmtcateId->rowCount() > 0) {
                $arrcateId = $stmtcateId->fetchAll(); ?>
                <option value="">請選擇</option>
                <?php for ($i = 0; $i < count($arrcateId); $i++) {
                ?>
                    <option value="<?php echo $arrcateId[$i]['categoryId'] ?>"><?php echo $arrcateId[$i]['cateName'] ?></option>

            <?php    }
            } ?>
        </select>
    </form>

    <!-- 商品細則選擇表單 -->
    <form name="myList" method="POST" enctype="application/x-www-form-urlencoded" action="./addToList.php">
        <?php
        //僅回傳指定的 $_SESSION['itemArr']
        // echo "<pre>";
        // print_r($_SESSION['itemArr']['iId']);
        // print_r($_SESSION['itemArr']);
        // echo "</pre>";
        ?>
        <?php if (isset($_SESSION['itemArr'])) { ?>
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">商品名稱</label>
            <table>
                <thead class="tabh">
                    <tr>
                        <th>勾選</th>
                        <th>商品名稱</th>
                        <th>商品價格</th>
                        <th>商品庫存</th>
                        <th>數量</th>
                    </tr>
                </thead>
                <tbody class="tabb">
                    <?php for ($i = 0; $i < count($_SESSION['itemArr']); $i++) {
                        // if(isset($_SESSION['itemArr']['categoryId'])){
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="<?php echo $_SESSION['itemArr'][$i]['iId'] . '[]' ?>" value="<?php echo $_SESSION['itemArr'][$i]['iId'] ?>">
                            </td>
                            <td>
                                <?php echo $_SESSION['itemArr'][$i]['iName'] ?>
                            </td>
                            <td>
                                <?php echo $_SESSION['itemArr'][$i]['iPrice'] ?>
                            </td>
                            <td>
                                <?php echo $_SESSION['itemArr'][$i]['iQty'] ?>
                            </td>
                            <td>
                                <input type="number" name="<?php echo $_SESSION['itemArr'][$i]['iId'] . '[]' ?>" value="" maxlength="5" min="1" max="<?php echo $_SESSION['itemArr'][$i]['iQty'] ?>">
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            <?php if (isset($_POST['iId'])) { ?>
                <input type="hidden" name="iId" value="<?php echo (int)$_POST['iId'] ?>">
            <?php }
            ?>
            <button type="submit" class="btn btn-primary my-1">加入商品</button>

    </form>
<?php } else {
        } ?>

<!-- 總計 -->

<?php
//僅回傳指定的 $_SESSION['cart']
// echo "<pre>";
// print_r($_SESSION['cart']);
// echo "</pre>";

?>

<?php //session_unset()
?>
<!-- 訂單成立 -->
<form name="myOrder" method="POST" action="./addToOrder.php">
    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">訂單內容</label>
    <table>
        <thead class="tabh">
            <tr>
                <!-- <th>勾選</th> -->
                <th>商品名稱</th>
                <th>商品價格</th>
                <th>數量</th>
                <th>小計</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody class="tabb">
            <?php
            //結合總計
            $arrTotal = [];
            $total = 0;
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                $sqlTotal = "SELECT `i`.`iId`, `i`.`iName`, `i`.`iPrice`,`i`.`iQty`, `i`.`iCateId`, `c`.`categoryId` FROM `items` AS `i` JOIN `categories` AS `c` ON `i`.`iCateId` = `c`.`categoryId` WHERE `iId` = ? ";

                //比對購物車iId
                for ($i = 0; $i < count($_SESSION['cart']); $i++) {
                    $arrKeys = array_keys($_SESSION['cart']);
                    $arrParam = [
                        $arrKeys[$i]
                    ];
                    $stmt = $pdo->prepare($sqlTotal);
                    $stmt->execute($arrParam);

                    //若商品項目個數>0, 把買家購買的數量加到查詢結果裡
                    if ($stmt->rowCount() > 0) {
                        $arrItem = $stmt->fetchAll()[0];
                        $arrItem['cartQty'] = $_SESSION['cart'][$arrKeys[$i]][1];

                        $arrTotal[] = $arrItem;
                    }
                    $total += (int)$arrTotal[$i]['iPrice'] * (int)$arrItem['cartQty'];

            ?>

                    <tr>
                        <td>
                            <?php echo $arrTotal[$i]['iName'] ?>
                            <input type="hidden" name="oListName[]" value="<?php echo $arrTotal[$i]['iName'] ?>">
                        </td>
                        <td>
                            <?php echo $arrTotal[$i]['iPrice'] ?>
                            <input type="hidden" name="oListPrice[]" value="<?php echo $arrTotal[$i]['iPrice'] ?>">
                        </td>
                        <td>
                            <input type="number" name="oQty[]" value="<?php echo $arrTotal[$i]['cartQty'] ?>" maxlength="5" min="1" max="<?php echo $arrTotal[$i]['iQty'] ?>">
                        </td>
                        <td> <input type="text" class="form-control" name="subtotal[]" value="<?php echo ($arrTotal[$i]["iPrice"] * $arrTotal[$i]["cartQty"]) ?>" maxlength="10"></td>
                        <td>
                            <a href="./deleteNewId.php?idx=<?php echo $arrTotal[$i]['iId'] ?>">刪除</a>
                        </td>
                    </tr>
                    <input type="hidden" name="chk1[]" value="<?php echo $arrTotal[$i]['iId'] ?>">
                <?php } ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <!-- 使用者帳號 -->
    <?php if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) { ?>
        <div class="form-group pt-3">
            <h3>目前總額: <mark id-="total"><?php echo $total ?></mark></h3>
            <input type="hidden" name="totalPrice" value="<?php echo $total ?>"> 
        </div>
    <?php } ?>
    <div class="form-group">
        <label for="exampleFormControlInput1">使用者帳號</label>
        <select name="uAcco" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option value="">請選擇</option>
            <?php
                $sql = "SELECT `uAcco` FROM `users`";
                $stmtuser = $pdo->query($sql);
                if ($stmtuser->rowCount() > 0) {
                    $arrName = $stmtuser->fetchAll(); ?>
                <?php
                    for ($i = 0; $i < count($arrName); $i++) {
                ?>
                    <option value="<?php echo $arrName[$i]['uAcco'] ?>"><?php echo $arrName[$i]['uAcco'] ?></option>

            <?php    }
                } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary my-1 ml-0">送出</button>

<?php }
            //僅回傳指定的 $_SESSION['cart']
            // echo "<pre>";
            // print_r($_SESSION['cart'][$k]);
            // echo "</pre>";
?>
</form>
<?php require_once("../footerMain.php");?>

<?php //session_unset();
?>