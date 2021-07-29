<?php require_once '../db.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <h3>請選擇上傳的文件</h3>
    <form action="./impoExcel.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="uploadExcel">
        <input type="submit" value="送出" style="width: 70px;">
    </form>
</body>

</html>