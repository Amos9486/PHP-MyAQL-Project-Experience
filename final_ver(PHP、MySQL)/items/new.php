<?php
// require_once('./checkSession.php');
require_once('../db.inc.php');
require_once('../headerMain.php');
require_once('../nav.php');
?>


<?php require_once('./templates/title.php') ?>

<form name="myForm" method="POST" action="./insert.php" enctype="multipart/form-data">
    <table class="border">
        <thead class="tabh">
            <tr>
                <th class="border">商品分類</th>
                <th class="border">商品名稱</th>
                <th class="border">商品圖片</th>
                <th class="border">商品簡介</th>
                <th class="border">商品數量</th>
                <th class="border">商品價格</th>
            </tr>
        </thead>
        <tbody class="tabb">
            <tr>
                <td class="border">
                    <select name="iCateId" id="iCateId">
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
                    <input type="text" name="iName" id="iName" value="" maxlength="20">
                </td>

                <td class="border">
                    <input type="file" name="iImg">

                </td>

                <td class="border">
                    <input type="text" name="iDiscr" id="iDiscr" value="">
                </td>

                <td class="border">
                    <input type="text" name="iQty" id="iQty" value="" maxlength="5">
                </td>

                <td class="border">
                    <input type="text" name="iPrice" id="iPrice" value="" maxlength="7">
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="border" colspan="6">
                    <input type="submit" name="submit" value="新增">
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<?php require_once("../footerMain.php"); ?>