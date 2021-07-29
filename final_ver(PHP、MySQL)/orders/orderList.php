<!-- 5/7進度
    navbar title待新增
    排版
    標題處(全選) + 全選功能
    $sql未完成
 -->

<?php
// require_once '../checkSession.php';
session_start();
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';

$total = $pdo->prepare("SELECT count(1) AS `count` FROM `orders_list` WHERE `oId` = ? ");
$total->execute([$_GET['oId']]);

// $numPerPage = 5;
// $totalPages = ceil($total / $numPerPage);

// //設定頁數、回傳值
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $page = $page < 1 ? 1 : $page;

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
                        <li class="nav-item">
                            <a class="nav-link active" href="./orderList.php">訂單詳情</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="./edit.php">訂單修改</a>
                        </li> -->
                        <li class="nav-item">
                            <a a class="nav-link" href="./new.php">新增訂單</a>
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

    <h3>訂單內容</h3>
    <form name="myForm" method="POST" enctype="multipart/form-data" action="./deleteolIds.php">
        <table>
            <thead class="tabh">
                <tr>
                    <th>全選</th>
                    <th>訂單編號</th>
                    <th>使用者帳號</th>
                    <th>商品編號</th>
                    <th>商品名稱</th>
                    <th>商品單價</th>
                    <th>商品數量</th>
                    <th>總金額</th>
                    <th>新增時間</th>
                    <th>更新時間</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody class="tabb">
                <?php if ($total->rowCount() > 0) {

                    $sql = "SELECT `o`.`oListId`, `o`.`oId`, `orders`.`uAcco`, `o`.`iId`, `o`.`oListName`, `o`.`oListPrice`, `o`.`oQty`, `o`.`created_at`, `o`.`updated_at`
                FROM `orders_list` AS `o`
                JOIN `orders` ON `o`.`oId` = `orders`.`oId`
                WHERE `o`.`oId` = ?
                ORDER BY `o`.`oListId` ASC";
                    $arrParam = [
                        $_GET['oId']
                    ];
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($arrParam);
                    if ($stmt->rowCount() > 0) {
                        $arr = $stmt->fetchAll();
                        for ($i = 0; $i < count($arr); $i++) {
                ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['oListId'] ?>">
                                </td>
                                <td>
                                    <?php echo $arr[$i]['oId'] ?>
                                    <input type="hidden" name="oId[]" value="<?php echo $arr[$i]['oId'] ?>">
                                </td>
                                <td>
                                    <?php echo $arr[$i]['uAcco'] ?>
                                </td>
                                <td>
                                    <?php echo $arr[$i]['iId'] ?>
                                </td>
                                <td>
                                    <?php echo $arr[$i]['oListName'] ?>
                                </td>
                                <td>
                                    <?php echo $arr[$i]['oListPrice'] ?>
                                </td>
                                <td>
                                    <?php echo $arr[$i]['oQty'] ?>
                                </td>
                                <td>
                                    <?php echo $arr[$i]['oListPrice'] * $arr[$i]['oQty'] ?>
                                </td>
                                <td>
                                    <?php echo $arr[$i]['created_at'] ?>
                                </td>
                                <td>
                                    <?php echo $arr[$i]['updated_at'] ?>
                                </td>
                                <td>
                                    <!-- <a href="./edit.php?oId=<?php echo $arr[$i]['oId'] ?>&oListId=<?php echo $arr[$i]['iId'] ?>">修改</a> -->
                                    <a href="./deleteList.php?oId=<?php echo $arr[$i]['oId'] ?>&oListId=<?php echo $arr[$i]['iId'] ?>">刪除</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="11">
                                <input type="submit" name="smb" value="批次刪除">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <button><a href="./orders.php">返回訂單總表</a></button>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="11">
                                <?php
                                for ($i = 1; $i <= $totalPages; $i++) { ?>
                                    <a href="?page=<?php echo $i ?>">
                                        <?php echo $i ?>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr> -->
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="11">
                            <?php echo "查無訂單" ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11">
                            <button><a href="./new.php">新增訂單</a></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </form>

<?php require_once("../footerMain.php");?>