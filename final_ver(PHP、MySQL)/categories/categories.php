<?php
// require_once './checkSessionAdmin.php';
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';

$sqlTotal = "SELECT COUNT(1) AS `count` FROM `categories`";
$stmtTotal = $pdo->query($sqlTotal); //抓取所有資料給total用
$arrTotal = $stmtTotal->fetchALL()[0]; //回傳陣列 抓一筆資料
$total = $arrTotal['count']; //count欄位總共幾筆資料

$numPerPage = 6; //每頁幾筆
$totalPages = ceil($total / $numPerPage); //總頁數 /
// echo $totalPages;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //目前網頁指定的第幾頁
$page = $page < 1 ? 1 : $page;

?>




<div class="container  mt-5 ">
  <div class="row">
    <div class=" col-12 p-3 titlecolor text-white  mt-5 ">
      <h1 class="hh1">CATEGORIES</h1>
    </div>
  </div>
</div>



<div class="container bg-light pb-3 ">
  <div class="row">

    <div class=" col-12 col-sm-12 d-flex justify-content-center pt-5 ">


      <form name="myForm" method="POST" action="./insertCategory.php">

        <table>
          <thead>
            <tr class="tabh">
              <th>商品編號</th>
              <th>商品類別</th>
              <th>上層編號</th>
              <th>新增時間</th>
              <th>更新時間</th>
              <th>編輯</th>
              <th>刪除</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $sql = "SELECT `categoryId`,`cateName`,`cateParentId`,`created_at`,`updated_at` FROM `categories` ORDER BY `categoryId` ASC 
          LIMIT ?,?";
            $arrParam = [($page - 1) * $numPerPage, $numPerPage];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            if ($stmt->rowCount() > 0) {
              $arr = $stmt->fetchAll();

              for ($i = 0; $i < count($arr); $i++) { //5 0 1 2 3
            ?>
                <tr class='tabb'>
                  <td class="td-1"><?php echo  $arr[$i]['categoryId'] ?>
                  </td>

                  <td><?php echo  $arr[$i]['cateName'] ?>
                  </td>

                  <td><?php echo  $arr[$i]['cateParentId'] ?>

                  </td>

                  <td><?php echo  $arr[$i]['created_at']  ?>

                  </td>

                  <td><?php echo  $arr[$i]['updated_at']  ?>

                  </td>

                  <td>
                    <a href="./editCategory.php?editCategoryId=<?php echo $arr[$i]['categoryId']  ?>">編輯</a>

                  </td>

                  <td>
                    <a href="./deleteCategory.php?deleteCategoryId=<?php echo $arr[$i]['categoryId'] ?>">刪除</a>
                  </td>

                </tr>


            <?php
              }
            }
            ?>


          <tfoot>
            <tr>
              <td class="td-block" colspan="7"><?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                  <a href="?page=<?php echo $i ?>"><?php echo $i ?> </a>

                <?php  }  ?>
              </td>

            </tr>

          </tfoot>

          </tbody>


        </table>


      </form>


    </div>



  </div>

  <div class="container">
    <div class=" d-flex justify-content-center mt-5 ">
      <div class=" ablock">
        <a href="./new.php">新增</a>
      </div>
    </div>
  </div>

</div>







</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>





</html>