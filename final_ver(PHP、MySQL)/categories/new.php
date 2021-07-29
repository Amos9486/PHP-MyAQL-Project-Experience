<?php
// require_once './checkSessionAdmin.php';
require_once '../db.inc.php';
require_once '../headerMain.php';
require_once '../nav.php';
?>


<div class="container mt-5 ">
  <div class="row">
    <div class=" col-12 p-3 titlecolor text-white  mt-5 ">
      <h1 class="hh1">ADD CATEGORIES</h1>
    </div>
  </div>
</div>

<div class="container bg-light pb-5  ">
  <div class="row">

    <div class=" col-12 col-sm-12 d-flex justify-content-center pt-5
      my-5 ">

      <form name="myForm" method="POST" action="./insertCategory.php">

        <table class="mb-5">
          <thead class="mb-5">
            <tr class='tabh'>
              <th>類別名稱</th>
              <th>上層編號</th>
            </tr>
          </thead>
          <tbody>
            <tr class="tabb">
              <td><input type="text" name="cateName" value="" maxlength="50"></td>
              <td><input type="text" name="cateParentId" value="" maxlength="50"></td>
            </tr>


          </tbody>


        </table>
        <div class="  d-flex justify-content-center mtt ">
          <tr>
            <td class="td-1  ablock " colspan="2"><input type="submit" name='sub' value="新增">
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