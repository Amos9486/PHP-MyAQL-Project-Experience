<?php
require_once("./header.php");
?>


<div class="dashboard">
    <div class="container">
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="./files/pics/user.png">
                    <h3>會員帳號</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>◆可維護由前臺註冊的會員帳號。</p>
                    <p>◆密碼係由雜湊處理保護，如無法通過「忘記密碼」的程序修改，請聯絡系統開發人員。</p>
                    <a href="./users/account_user.php">開始維護 >></a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="./files/pics/partner.png">
                    <h3>店家帳號</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>◆可維護合作店家的系統帳號。</p>
                    <p>◆密碼係由雜湊處理保護，如忘記密碼，請依照程序提出申請，並聯絡系統開發人員。</p>
                    <a href="./partners/partner.php">開始維護 >></a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="./files/pics/category.png">
                    <h3>商品類別</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>◆可維護用於本系統的商品類別。</p>
                    <p>◆父層類別均已定義完畢，請勿任意刪除更動。</p>
                    <a href="./categories/categories.php">開始維護 >></a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="./files/pics/item.png">
                    <h3>商品管理</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>◆可維護本系統上架的所有商品。</p>
                    <p>◆請盡可能詳細填寫商品的相關資料，包含照片等資訊。</p>
                    <a href="./items/admin.php">開始維護 >></a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="face face1">
                <div class="content">
                    <img src="./files/pics/order.png">
                    <h3>訂單管理</h3>
                </div>
            </div>
            <div class="face face2">
                <div class="content">
                    <p>◆可維護於前臺成立的所有訂單。</p>
                    <p>◆如需透過後臺新增訂單，則請務必從會員帳號中選擇購買人，並於備註欄註明本次訂單係由後臺建立。</p>
                    <a href="./orders/orders.php">開始維護 >></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("./footer.php");
