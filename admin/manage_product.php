<?php
require('top.inc.php');
$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$status = '';
$required = 'required';
$msg = '';
if (isset($_GET['id']) && $_GET['id'] != '') {
   $required = '';
   $id = get_safe_value($con, $_GET['id']);
   $update = mysqli_query($con, "select * from product where id='$id'");
   $check = mysqli_num_rows($update);
   if ($check > 0) {
      $res = mysqli_fetch_assoc($update);
      $categories_id = $res['categories_id'];
      $name = $res['name'];
      $mrp = $res['mrp'];
      $price = $res['price'];
      $qty = $res['qty'];
      $short_desc = $res['short_desc'];
      $description = $res['description'];
      $meta_title = $res['meta_title'];
      $meta_desc = $res['meta_desc'];
      $meta_keyword = $res['meta_keyword'];
   } else {
      header('location:product.php');
      die();
   }
}
if (isset($_POST['submit'])) {
   $categories_id = get_safe_value($con, $_POST['categories_id']);
   $name = get_safe_value($con, $_POST['name']);
   $mrp = get_safe_value($con, $_POST['mrp']);
   $price = get_safe_value($con, $_POST['price']);
   $qty = get_safe_value($con, $_POST['qty']);
   $short_desc = get_safe_value($con, $_POST['short_desc']);
   $description = get_safe_value($con, $_POST['description']);
   $meta_title = get_safe_value($con, $_POST['meta_title']);
   $meta_desc = get_safe_value($con, $_POST['meta_desc']);
   $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);
   $update = mysqli_query($con, "select * from product where name='$name'");
   $check = mysqli_num_rows($update);
   if ($check > 0) {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         $dataid = mysqli_fetch_assoc($update);
         if ($id == $dataid['id']) {
         } else {
            $msg = 'product Alraedy Exists';
         }
      } else {
         $msg = 'product Alraedy Exists';
      }
   }
   if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
                $msg="Please select png,jpg or jpeg file";
   }
   else{
   if ($msg == '') {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         if ($_FILES['image']['name'] != '') {
            $temp = "select image from product where id='$id'";

            $delimage_sql = mysqli_query($con, $temp);
            $delimage = mysqli_fetch_assoc($delimage_sql);
            unlink(PRODUCT_IMAGE_SERVER_PATH. $delimage['image']);
            $image = rand(11111, 99999) . '.' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
            mysqli_query($con, "update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',image='$image',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',status='1' where id='$id' ");
         } else {
            mysqli_query($con, "update product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',status='1' where id='$id' ");
         }
      } else {
         $image = rand(11111, 99999) . '.' . $_FILES['image']['name'];
         move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
         mysqli_query($con, "insert into product(categories_id,name,mrp,price,qty,short_desc,description,meta_title,meta_desc,meta_keyword,status,image) value('$categories_id','$name','$mrp','$price','$qty','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword','1','$image')");
      }
      header('location:product.php');
      die();
   }
}
}

?>
<div class="content pb-0">
   <div class="animated fadeIn">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header"><strong>Product</strong><small> Form</small></div>
               <form method="post" enctype="multipart/form-data">
                  <div class="card-body card-block">
                     <div class="form-group">
                        <label for="categories" class=" form-control-label">Categories Name</label>
                        <select class="form-control" name="categories_id" id="">
                           <option value="">Select option</option>
                           <?php
                           $sql = "select id,categories from categories order by categories desc";
                           $res = mysqli_query($con, $sql);
                           while ($row = mysqli_fetch_assoc($res)) {
                              if ($row['id'] == $categories_id) {
                                 echo "<option value=" . $row['id'] . " selected>" . $row['categories'] . "</option>";
                              } else {
                                 echo "<option value=" . $row['id'] . ">" . $row['categories'] . "</option>";
                              }
                           }
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="name" class=" form-control-label">Product Name</label>
                        <input type="text" name="name" placeholder="Enter your product name" class="form-control" required value="<?php echo $name ?>">
                     </div>
                     <div class="form-group">
                        <label for="mrp" class=" form-control-label">MRP</label>
                        <input type="text" name="mrp" placeholder="Enter mrp" class="form-control" required value="<?php echo $mrp ?>">
                     </div>
                     <div class="form-group">
                        <label for="price" class=" form-control-label">Price</label>
                        <input type="text" name="price" placeholder="Enter price" class="form-control" required value="<?php echo $price ?>">
                     </div>
                     <div class="form-group">
                        <label for="qty" class=" form-control-label">QTY</label>
                        <input type="text" name="qty" placeholder="Enter qty" class="form-control" required value="<?php echo $qty ?>">
                     </div>
                     <div class="form-group">
                        <label for="image" class=" form-control-label">image</label>
                        <input type="file" name="image" placeholder="Enter image" class="form-control" <?php echo $required ?>>
                     </div>
                     <div class="form-group">
                        <label for="short_desc" class=" form-control-label">short_desc</label>
                        <input type="text" name="short_desc" placeholder="Enter short_desc" class="form-control" required value="<?php echo $short_desc ?>">
                     </div>

                     <div class="form-group">
                        <label for="description" class=" form-control-label">description</label>
                        <input type="text" name="description" placeholder="Enter description" class="form-control" required value="<?php echo $description ?>">
                     </div>
                     <div class="form-group">
                        <label for="meta_title" class=" form-control-label">meta_title</label>
                        <input type="text" name="meta_title" placeholder="Enter meta_title" class="form-control" required value="<?php echo $meta_title ?>">
                     </div>
                     <div class="form-group">
                        <label for="meta_desc" class=" form-control-label">meta_desc</label>
                        <input type="text" name="meta_desc" placeholder="Enter meta_desc" class="form-control" required value="<?php echo $meta_desc ?>">
                     </div>
                     <div class="form-group">
                        <label for="meta_keyword" class=" form-control-label">meta_keyword</label>
                        <input type="text" name="meta_keyword" placeholder="Enter meta_keyword" class="form-control" required value="<?php echo $meta_keyword ?>">
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