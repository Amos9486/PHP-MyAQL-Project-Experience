<?php
    // require_once('./checkSession.php');
    require_once('../db.inc.php');
    

    $sql = "INSERT INTO `items`
            (`iCateId`, `iName`, `iImg`, `iDiscr`, `iQty`, `iPrice`)
            VALUES
            (?,?,?,?,?,?)";
            
    if( $_FILES['iImg']['error'] === 0 ) {
        $strDatetime = date('YmdHis');
        $extension = pathinfo($_FILES['iImg']['name'], PATHINFO_EXTENSION);
        $imgFileName = $strDatetime.".".$extension;
        $isSuccess = move_uploaded_file($_FILES['iImg']['tmp_name'], '../files/' . $imgFileName);

        if( !$isSuccess ) {
            header('Refresh: 2; url=./admin.php');
            echo "圖片上傳失敗";
            exit();
        }
    }

    $arrParam = [
        $_POST['iCateId'],
        $_POST['iName'],
        $imgFileName,
        $_POST['iDiscr'],
        $_POST['iQty'],
        $_POST['iPrice'],
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if( $stmt->rowCount() > 0 ) {
        header('Refresh: 2; url=./admin.php');
        echo "新增成功";
    } else {
        header('Refresh: 2; url=./new.php');
        echo "新增失敗";
    }
