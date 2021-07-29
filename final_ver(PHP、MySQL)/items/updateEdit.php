<?php
    // require_once('./checkSession.php');
    require_once('../db.inc.php');
  
    $sql = "UPDATE `items`
            SET
            `iCateId` = ?,
            `iName` = ?,
            `iDiscr` = ?,
            `iQty` = ?,
            `iPrice` = ? ";

    $arrParam = [
        $_POST['iCateId'],
        $_POST['iName'],
        $_POST['iDiscr'],
        $_POST['iQty'],
        $_POST['iPrice']
    ];

    if( $_FILES['iImg']['error'] === 0 ) {
        $strDatetime = date('YmdHis');
        $extension = pathinfo($_FILES['iImg']['name'], PATHINFO_EXTENSION);
        $iImg = $strDatetime . "." . $extension;
        $isSuccess = move_uploaded_file($_FILES['iImg']['tmp_name'], '../files/' . $iImg);

        if( $isSuccess ) {
            $sqlGetImg = "SELECT `iImg` FROM `items` WHERE `iId` = ? ";

            $stmtGetImg = $pdo->prepare($sqlGetImg);
            $arrGetImgParam = [(int)$_POST['iId']];
            $stmtGetImg->execute($arrGetImgParam);

            if( $stmtGetImg->rowCount() > 0 ) {
                $arrImg = $stmtGetImg->fetchAll()[0];
                if( $arrImg['iImg'] !== NULL ) {
                    @unlink('./files/' . $arrImg['iImg']);
                }

                $sql .= ", `iImg` = ? ";
                $arrParam[] = $iImg;
            }
        }
    }

    $sql .= "WHERE `iId` = ? ";
    $arrParam[] = (int)$_POST['iId'];


    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if( $stmt->rowCount() > 0 ) {
        header('Refresh: 2; url=./admin.php');
        echo "更新成功";
    } else {
        header('Refresh: 2; url=./admin.php');
        echo "更新失敗";
    }
