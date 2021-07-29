<?php
// require_once './checkSessionAdmin.php';
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';
?>

<div class="container mt-5  ">
  <div class="row">
    <div class=" col-12 p-3 titlecolor text-white  mt-5 ">
      <h1 class="hh1">EDIT CATEGORIES</h1>
    </div>
  </div>
</div>


<div class="container bg-light pb-3 ">
  <div class="row">

    <div class=" col-12 col-sm-12 d-flex justify-content-center pt-5 ">

      <form name="myForm" method="POST" action="./updateCategory.php">
        <table>
          <thead>
            <tr class="tabh">
              <th>商品編號</th>
              <th>商品類別</th>
              <th>上層編號</th>
              <th>新增時間</th>
              <th>更新時間</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT `categoryId`,`cateName`,`cateParentId`,`created_at`,`updated_at` FROM `categories`
        WHERE `categoryId` = ? ";
            $stmt = $pdo->prepare($sql);
            $arrParam = [(int)$_GET['editCategoryId']];
            $stmt->execute($arrParam);

            if ($stmt->rowCount() > 0) {
              $arr = $stmt->fetchAll()[0];
            ?>
              <tr class='tabb'>
                <td>
                  <?php echo $arr['categoryId'] ?>
                </td>
                <td>
                  <input type="text" name="cateName" placeholder="<?php echo $arr['cateName'] ?>" maxlength="100">
                </td>
                <td>
                  <input type="text" name="cateParentId" placeholder="<?php echo $arr['cateParentId'] ?>" maxlength="100">
                </td>
                <td><?php echo $arr['created_at'] ?></td>
                <td><?php echo $arr['updated_at'] ?></td>

              </tr>
            <?php
            } else {
            ?>
              <tr>
                <td class="td-1  " colspan="5">沒有資料</td>
              </tr>
            <?php
            }
            ?>
            <?php
            ?>

          </tbody>
        </table>
        <div class="  my-5 d-flex justify-content-center ">
          <tr>
            <td class="td-1 td-block "><input type="submit" name='sub' value="修改">
              <input type="hidden" name="editCategoryId" value="<?php echo (int)$_GET['editCategoryId'] ?>">
            </td>
          </tr>
        </div>


      </form>






    </div>
  </div>
</div>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</body>

</html>