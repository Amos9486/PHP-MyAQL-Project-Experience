<h4>後端管理頁面</h4>

<div class="d-flex">

    <a class="btn btn-primary btn-lg active mx-2" role="button" aria-pressed="true" href="./account_user.php">會員資料</a>


    <a class="btn btn-primary btn-lg active mx-2" role="button" aria-pressed="true" href="./insert.php">新增</a>

    <a class="btn btn-primary btn-lg active mx-2" role="button" aria-pressed="true" href="./garbage.php">垃圾桶</a>


    <form class="mx-2 my-2" action="../convertBack.php" method="post" enctype="multipart/form-data">
        <label for="">請放入xlsx檔</label>
        <input type="file" name="excel" value="">
        <input type="submit">
    </form>

    <form class="mx-2 my-2" name="mySearch" method="GET" action="./searchback.php" class="mb-2 my-2">
        <input type="text" placeholder="請輸入關鍵字" name="inputSearch" id="inputSearch" value="">
        <input type="submit" value="搜尋">
    </form>
    <form class="mx-2 my-2" name="orderFrom" method="get" action="./orderback.php" class="mb-2 my-2">
        依出生年月日排序:<select name="orderForm" id="orderorm" onChange="submit()">
            <option value="#" selected>請選擇</option>
            <option value="ASC">由小到大</option>
            <option value="DESC">由大到小</option>
        </select>
    </form>
</div>