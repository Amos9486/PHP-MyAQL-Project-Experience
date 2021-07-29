<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./index.css">
</head>


<body>
    <div class="loginCard frontPage">
        <div>
            <h1>Dashboard Login</h1>
        </div>
        <div> 
            <form action="./dashboardLogin.php" method="POST">
                <div class="inputDiv">
                    <input type="text" name="account" placeholder="請輸入帳號">
                    <label for="input">請輸入帳號</label>
                    <div class="subLine"></div>
                </div>
                <div class="inputDiv">
                    <input type="password" name="pwd" placeholder="請輸入密碼">
                    <label for="input">請輸入密碼</label>
                    <div class="subLine"></div>
                </div>
                <button class="button" style="vertical-align:middle" onclick="submit()"><span>登入 </span></button>
            </form>
        </div>
        <ul class="bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
</body>

</html>