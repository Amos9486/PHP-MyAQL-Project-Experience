<?php
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';

// 1.設定頁數
$perPage = isset($_COOKIE['choosePage']) ? $_COOKIE['choosePage'] : 5;
$totalData = $pdo->query('SELECT COUNT(1) FROM `partners` WHERE `recycleIndex` = 0')->fetch(PDO::FETCH_NUM)[0];

// 4-2.if條件確保搜尋功能找到的資料筆數是正確的
if (isset($_COOKIE['findKey']) && $_COOKIE['findKey'] !== "") {
    $totalData = $pdo->query('SELECT COUNT(1) FROM `partners` WHERE (`pId` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pAcco` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pName` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pPhone` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pAddr` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pDiscr` LIKE "%' . $_COOKIE['findKey'] . '%") AND `recycleIndex` = 0')->fetch(PDO::FETCH_NUM)[0];
}

$totalPage = ceil($totalData / $perPage);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$dataSql = 'SELECT `pId` AS "流水號",`pAcco` AS "店家帳號",`pName` AS "店家姓名",`pPhone` AS "店家電話",`pAddr` AS "店家地址",`pDiscr` AS "店家描述",`created_at` AS "新增時間",`updated_at` AS "修改時間" 
            FROM `partners` 
            WHERE `recycleIndex` = 0
            LIMIT ?,?';

// 4-3.建立搜尋語句
if (isset($_COOKIE['findKey']) && $_COOKIE['findKey'] !== "") {
    $dataSql = 'SELECT `pId` AS "流水號",`pAcco` AS "店家帳號",`pName` AS "店家姓名",`pPhone` AS "店家電話",`pAddr` AS "店家地址",`pDiscr` AS "店家描述",`created_at` AS "新增時間",`updated_at` AS "修改時間" 
            FROM `partners` 
            WHERE (`pId` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pAcco` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pName` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pPhone` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pAddr` LIKE "%' . $_COOKIE['findKey'] . '%" OR `pDiscr` LIKE "%' . $_COOKIE['findKey'] . '%") AND `recycleIndex` = 0 LIMIT ?,?';
}

// 5-2.設定排序用的語句
if (isset($_COOKIE['orderCol']) && $_COOKIE['orderCol'] !== "" && isset($_COOKIE['orderType']) && $_COOKIE['orderType'] !== "") {
    $findStr = substr($dataSql, 0, -9);
    $dataSql = $findStr . "ORDER BY " . $_COOKIE['orderCol'] . " " . $_COOKIE['orderType'] . " LIMIT ?,?";
}

$pageArr = [($page - 1) * $perPage, $perPage];
$dataStmt = $pdo->prepare($dataSql);
$dataStmt->execute($pageArr);
$dataArr = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

// 將key值提取出來，轉存成值(新陣列) 
if (!empty($dataArr)) {
    $headerKeys = array_keys($dataArr[0]);
}
?>

<!-- 因為有引入其他的header，這邊只需要撈剩餘的LINK就好 -->
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<!-- <link rel="stylesheet" href="./partnerCSS.css"> -->
<link rel="stylesheet" href="../svg.css">



<!-- 2.建構表單主體 -->
<!-- 3.建構新增與刪除功能(刪除功能移至垃圾桶) -->
<a href="./newPartner.php"><img src="../files/pics/new2.svg" class="svgImg"></a>
<!-- 6.建構垃圾桶功能(會將刪除功能設計於垃圾桶頁面中) -->
<span id="iconRecy"><a href="./recyPartner.php"><img src="../files/pics/recycle2.svg" class="svgImg"></a></span>
<!-- 7.建構上傳EXCEL功能 -->
<!-- <span id="iconImport"><a href="./impoPartner.php"><i class="fas fa-file-import"></i></a></span> -->
<!-- 4-1.建構搜尋功能 -->
<input id="textFind" type="text" placeholder="請輸入資料進行查詢" title="可查詢欄位：店家帳號、店家姓名、店家電話、店家地址、店家描述">
<span id="iconFind"><a href="#"><img src="../files/pics/search.svg" class="svgImg"></a></span>
<!-- 5-1.設定排序用的下拉選單 -->
<select name="orderCol" id="orderCol">
    <?php if (!isset($_COOKIE['orderCol'])) {
        echo '<option value="">請選擇</option>';
    } else {
        $selPara = [$_COOKIE["orderCol"], $headerKeys[$_COOKIE["orderCol"] - 1]];
        echo "<option value='$selPara[0]'>$selPara[1]</option>";
    }
    ?>
    <?php for ($i = 1; $i < count($headerKeys); $i++) { ?>
        <option value="<?php echo $i + 1 ?>"><?php echo $headerKeys[$i] ?></option>
    <?php } ?>
</select>
<select name="orderType" id="orderType">
    <?php if (!isset($_COOKIE['orderType'])) {
        echo '<option value="">請選擇</option>';
    } else if ($_COOKIE['orderType'] == "ASC") {
        echo '<option value="ASC">由小到大(A到Z)</option>';
    } else {
        echo '<option value="DESC">由大到小(Z到A)</option>';
    }
    ?>
    <option value="ASC">由小到大(A到Z)</option>
    <option value="DESC">由大到小(Z到A)</option>
</select>
<!-- <div class="container  mt-5 " style="min-width:100vw">
    <div class="row">
        <div class=" col-12 p-3 titlecolor text-white  mt-5 ">
            <h1 class="hh1">Partner</h1>
        </div>
    </div>
</div> -->
<?php if (!empty($dataArr)) { ?>
    <form action="" method="POST">
        <table>
            <thead class="tabh">
                <tr>
                    <th>選擇</th>
                    <th>編輯</th>
                    <?php for ($i = 1; $i < count($headerKeys); $i++) { ?>
                        <th><?php echo $headerKeys[$i] ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody class="tabb">
                <?php foreach ($dataArr as $k => $v) { ?>
                    <tr>
                        <td><?php echo "<input type='checkbox' name='partnerChk[]' value='" . $v[$headerKeys[0]] . "' id='" . $v[$headerKeys[0]] . "'>" ?></td>
                        <td><a href="./editPartner.php?pId=<?php echo $v[$headerKeys[0]] ?>"><img src="../files/pics/edit2.svg" class="svgImg"></a></td>
                        <?php
                        for ($i = 1; $i < count($v); $i++) { ?>
                            <td><?php echo $v[$headerKeys[$i]] ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot class="tabb">
                <td colspan="9">
                    <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                        <?php echo "<a href='./partner.php?page={$i}'>{$i}</a>" ?>
                    <?php } ?>
                </td>
            </tfoot>
        </table>
    </form>
<?php
} else {
    echo "<br>資料庫中沒有資料，請按上一頁返回。";
}
?>
<select name="choosePage" id="choosePage">
    <option value="<?php echo $perPage ?>"><?php echo $perPage ?></option>
    <option value="3">3</option>
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="20">20</option>
</select>
<input type="button" value="開啟垃圾桶" onclick="location.href='./recyListPartner.php'">
<script src="./partner.js"></script>
</body>

</html>