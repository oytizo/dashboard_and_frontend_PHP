<?php
require('top.inc.php');
$categories = '';
$msg = '';
if (isset($_GET['id']) && $_GET['id'] != '') {
   $id = get_safe_value($con, $_GET['id']);
   $update = mysqli_query($con, "select * from categories where id='$id'");
   $check = mysqli_num_rows($update);
   if ($check > 0) {
      $res = mysqli_fetch_assoc($update);
      $categories = $res['categories'];
   } else {
      header('location:categories.php');
      die();
   }
}
if (isset($_POST['submit'])) {
   $categories = get_safe_value($con, $_POST['categories']);
   $update = mysqli_query($con, "select * from categories where categories='$categories'");
   $check = mysqli_num_rows($update);
   if ($check > 0) {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         $dataid = mysqli_fetch_assoc($update);
         if ($id == $dataid['id']) {
         } else {
            $msg = 'Categories Alraedy Exists';
         }
      } else {
         $msg = 'Categories Alraedy Exists';
      }
   }
   if ($msg == '') {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         mysqli_query($con, "update categories set categories='$categories' where id='$id' ");
      } else {
         mysqli_query($con, "insert into categories(categories,status) value('$categories','1')");
      }
      header('location:categories.php');
      die();
   }
}

?>
<div class="content pb-0">
   <div class="animated fadeIn">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header"><strong>Categories</strong><small> Form</small></div>
               <form method="post">
                  <div class="card-body card-block">
                     <div class="form-group">
                        <label for="categories" class=" form-control-label">Categories Name</label>
                        <input type="text" name="categories" placeholder="Enter your categories name" class="form-control" required value="<?php echo $categories ?>">
                     </div>
                     <button id="payment-button" type="submit" name="submit" class="btn btn-sm btn-info">
                        <span id="payment-button-amount">Submit</span>
                     </button>
                  </div>
               </form>
               <h4 class="text-danger"><?php echo $msg ?></h4>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
require('footer.inc.php');
?>