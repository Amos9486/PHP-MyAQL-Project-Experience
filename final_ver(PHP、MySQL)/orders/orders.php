<!-- 5/7進度
    navbar title待新增
    排版
    標題處(全選) + 全選功能
    button 詳細清單 -> orderList的路徑待修
 -->

<?php
// require_once '../checkSession.php';
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';

$total = $pdo->query("SELECT count(1) AS `count` FROM `orders` ")->fetchAll()[0]['count'];

$numPerPage = 5;
$totalPages = ceil($total / $numPerPage);

//設定頁數、回傳值
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = $page < 1 ? 1 : $page;

//訂單總數 (若訂單 = 0，則 echo "先建立訂單")
?>


<?php require_once './nav.php'; ?>

<h3>訂單列表</h3>
<form name="myForm" method="POST" enctype="multipart/form-data" action="./deleteoIds.php">
    <table>
        <thead class="tabh">
            <tr>
                <th>全選</th>
                <th>訂單編號</th>
                <th>使用者帳號</th>
                <th>訂單總額</th>
                <!-- <th>付款方式</th>
                <th>訂單狀態</th> -->
                <th>新增時間</th>
                <th>更新時間</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody class="tabb">
            <?php if ($total > 0) {
                $sql = "SELECT `oId`,`uAcco`, `oPrice`,`cNum`,`oAddress`,`oName`,`oPhone`,`oMail`,`oDate`, `updated_at` FROM `orders` ORDER BY `oId` ASC
                        LIMIT ?, ? ";
                $arrParam = [
                    ($page - 1) * $numPerPage, $numPerPage
                ];
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);
                if ($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll();
                    for ($i = 0; $i < count($arr); $i++) {
            ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['oId'] ?>">
                            </td>
                            <td>
                                <?php echo $arr[$i]['oId'] ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['uAcco'] ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['oPrice'] ?>
                            </td>

                            <td>
                                <?php echo $arr[$i]['created_at'] ?>
                            </td>
                            <td>
                                <?php echo $arr[$i]['updated_at'] ?>
                            </td>
                            <td>
                                <button><a href="./orderList.php?oId=<?php echo $arr[$i]['oId'] ?>">詳細內容</a></button>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="10">
                            <input type="submit" name="smb" value="批次刪除">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <?php
                            for ($i = 1; $i <= $totalPages; $i++) { ?>
                                <a href="?page=<?php echo $i ?>">
                                    <?php echo $i ?>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="10">
                        <?php echo "查無訂單" ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="10">
                        <button><a href="./new.php">新增訂單</a></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
</form>

<?php require_once("../footerMain.php"); ?>