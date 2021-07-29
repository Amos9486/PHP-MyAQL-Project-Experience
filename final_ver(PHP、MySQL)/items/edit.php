<?php
// require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('../headerMain.php');
require_once('../nav.php');
?>

<?php require_once('./templates/title.php'); ?>

<form name="myForm" method="POST" action="./updateEdit.php" enctype="multipart/form-data">
    <table class="border">
        <thead class="tabh">
            <tr>
                <th class="border">商品分類</th>
                <th class="border">商品名稱</th>
                <th class="border">商品圖片</th>
                <th class="border">商品簡介</th>
                <th class="border">商品數量</th>
                <th class="border">商品價格</th>
                <th class="border">功能</th>
            </tr>
        </thead>

        <tbody class="tabb">
            <?php
            $sql = "SELECT `iCateId`, `iId`, `iName`, `iImg`, `iDiscr`, `iQty`, `iPrice`
                    FROM `items`
                    WHERE `iId` = ? ";

            $arrParam = [(int)$_GET['iId']];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            if ($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll()[0];
            ?>



                <td class="border">
                    <select name="iCateId" id="iCateId">
                        <option value="<?php echo $arr['iCateId'] ?>" selected><?php echo $arr['iCateId'] ?></option>
                        <?php $cateSql = "SELECT `categoryId` FROM `categories` WHERE 1";
                        $cateStmt = $pdo->query($cateSql);
                        $cateArr = $cateStmt->fetchAll(PDO::FETCH_NUM);
                        foreach ($cateArr as $k => $v) {
                            echo "<option value='$v[0]'>$v[0]</option>";
                        }
                        ?>
                    </select>
                </td>




                <td class="border">
                    <input type="text" name="iName" id="iName" value="<?php echo $arr['iName'] ?>" maxlength="20">
                </td>




                <td class="border">
                    <?php
                    if ($arr['iImg'] !== NULL) {
                    ?>
                        <img style="width: 350px;" class="iImg" src="../files/<?php echo $arr['iImg'] ?>">
                    <?php
                    }
                    ?>
                    <input type="file" name="iImg">
                </td>




                <td class="border">
                    <input type="text" name="iDiscr" value="<?php echo $arr['iDiscr'] ?>">
                </td>




                <td class="border">
                    <input type="text" name="iQty" value="<?php echo $arr['iQty'] ?>" maxlength="5">
                </td>



                <td class="border">
                    <input type="text" name="iPrice" value="<?php echo $arr['iPrice'] ?>" maxlength="7">
                </td>




                <td class="border">
                    <a href="./delete.php?iId=<?php echo $arr['iId'] ?>">刪除</a>
                </td>
                </tr>

            <?php
            } else {
            ?>
                <tr>
                    <td class="border" colspan="2">沒有資料</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <input type="submit" name="smb" value="修改">
    <input type="hidden" name="iId" value="<?php echo (int)$_GET['iId'] ?>">
</form>
<?php require_once("../footerMain.php"); ?>